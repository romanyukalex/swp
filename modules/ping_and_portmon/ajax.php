<?php
/****************************************************************
 * Snippet Name : module template (ajax part) 					* 
 * Scripted By  : RomanyukAlex		           					* 
 * Website      : http://popwebstudio.ru	   					* 
 * Email        : admin@popwebstudio.ru     					* 
 * License      : GPL (General Public License)					* 
 * Purpose 	 : some ajax functions							 	*
 * Access		 : via /ajax/								 	*
 ***************************************************************/
if($nitka=="1"){
	if($_REQUEST['action']=="ping" or $_REQUEST['action']=="fsockopen" or $_REQUEST['action']=="socket"){
		
		include($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/Ping.php");
		$host=$_REQUEST['someid1'];
		$ping = new Ping($host);
		if($_REQUEST['action']=="ping"){$montype="exec";}
		elseif($_REQUEST['action']=="fsockopen" or $_REQUEST['action']=="socket"){$montype=$_REQUEST['action'];}
		$latency = $ping->ping($montype);
		if ($latency !== false) {
		  echo $latency." ms";
		}
		else {
		  echo "недоступен";
		}
	}elseif($_REQUEST['action']=="get_mon_history"){
		/* Пример
		<form>
			<select name="mon_hist_month" id="mon_hist_month" onChange="get_monitor_history('1,2,3');">
				<option value="09.2015">Сентябрь 2015</option>
				<option value="08.2015">Август 2015</option>
			</select>
		</form>
		<div id="hist_table"></div>
		<script>
		function get_monitor_history(nodes){
			var mon_month = document.getElementById('mon_hist_month').value;
			ajaxreq(nodes,mon_month,'get_mon_history','hist_table','ping_and_portmon','downtime_SN.php');
		}

		get_monitor_history('1,2,3,6,7,8,9,10,11,12,13,14,15,16');
		</script>
		*/
	
		insert_function("process_user_data");
		# Узлы для вывода
		$mon_nodes_req=process_data($_REQUEST['someid1'],150);//ID нодов для вывода через запятую
		$mon_node=explode(",",$mon_nodes_req);
		if(count($mon_node)>1){
			
			foreach($mon_node as $mon_node_id){
				$nodes_sql.="ev.`node_id`=".$mon_node_id." or ";
				$nodes_name_sql.="`node_id`=".$mon_node_id." or ";
				
			}
			$nodes_sql="(".substr($nodes_sql,0,-4).")";
			$nodes_name_sql="(".substr($nodes_name_sql,0,-4).")";
			
		} elseif(count($mon_node)==1 and !$mon_node[0]==''){
			$nodes_sql="ev.`node_id`=".$mon_node[0];
			$nodes_name_sql="`node_id`=".$mon_node[0];
			
		}
		else {echo "Не выбран узел для вывода истории";exit();}
		
		# Месяц для вывода
		$mon_month=process_data($_REQUEST['someid2'],20);//Месяц для вывода
		//$firsdaythismonth=date("Y-m-01",strtotime ($mon_month));
		
		#Хостнеймы отдельно
		$mon_hosts_q=mysql_query("SELECT * FROM `$moduletableprefix-monitor-nodes` WHERE $nodes_name_sql ;");
		while($mon_hosts=mysql_fetch_array($mon_hosts_q)){
			$hostname[$mon_hosts['node_id']]=$mon_hosts['hostname_'.$language];
		}
		# История
		//echo "Следующий месяц ".date("Y-m",strtotime ($mon_month)+2678400);
		$mon_hist_qt="SELECT * FROM `$moduletableprefix-monitor-events` ev,`$tableprefix-monitor-nodes` n WHERE n.`node_id`=ev.`node_id` and $nodes_sql and `event_date` BETWEEN '$mon_month-01' AND '".date("Y-m",strtotime ($mon_month)+2678400)."-01' ORDER BY ev.`node_id` ASC , `event_date` ASC;";
		$mon_hist_q=mysql_query($mon_hist_qt);
		
		/*?><table><?*/
		
		# Считаем количество событий для каждого узла, понадобится в случае, когда падение - последнее событие в месяце
		while($mon_hist=mysql_fetch_array($mon_hist_q)){
			$nod_count[$mon_hist['node_id']]++;
		}

		mysql_data_seek($mon_hist_q, 0);
		
		# Формируем простои
		while($mon_hist=mysql_fetch_array($mon_hist_q)){
			if($prev_node_id!==$mon_hist['node_id'] or !$prev_node_id){// Новый узел и строчки для него есть
				$newnode=1;
				if($mode=="debug") echo "<br><br>".$mon_hist['hostname_'.$language]." (".$mon_hist['node_id'].")<br><br>";
				//$hostname[$mon_hist['node_id']]=$mon_hist['hostname_'.$language];
				if($prev_event)	unset($prev_event,$prev_event_date); // Обновляем данные
				$act_count=0; // Порядковый номер события в этом месяце для данного узла
			}
			$act_count++; // Обновили порядковый номер события
			
			if($mode=="debug") {echo "<hr><b>$act_count</b><br>".$mon_hist['event_date']." ".$mon_hist['event']."     /    ";
				if($prev_event_date) echo "Предыдущее событие было ".$prev_event_date."<br>";
				else echo "Предыдущее событие не найдено<br>";
			}
			// Дата (день) текущего события
			$cureventdate=date("Y-m-d",strtotime ($mon_hist['event_date']));
			if(($prev_event=="dead" and $mon_hist['event']=="alive") or($mon_hist['event']=="alive" and $newnode==1)){//Лежал и поднялся
				
				// Первое число date("Y-m-01",strtotime ($mon_hist['event_date']))
				$firsdaythismonth=date("Y-m-01",strtotime ($mon_hist['event_date']));
				if($newnode==1){// Самое первое событие в месяце и поднялся
					
					#Надо выставить простой за эту дату
					$prostoi[$mon_hist['node_id']][$cureventdate]=$prostoi[$mon_hist['node_id']][$cureventdate]+strtotime ($mon_hist['event_date'])-strtotime($cureventdate);
					if($mode=="debug") echo "Накопленный простой за $cureventdate равен ".$prostoi[$mon_hist['node_id']][$cureventdate]."<br>";
					#Надо выставить 24 часовые падения для всех дат от начала месяца ДО даты этого события 
					for($ccdt=1;date("Y-m-d",strtotime ($mon_hist['event_date'])- 86400*$ccdt)>=$firsdaythismonth;$ccdt++){
						$ccdtdate=date("Y-m-d",strtotime ($mon_hist['event_date'])- 86400*$ccdt);
						$prostoi[$mon_hist['node_id']][$ccdtdate]=86400; // Простой за эти даты равен 24 часа
						if($mode=="debug") echo "Накопленный простой за $ccdtdate равен ".$prostoi[$mon_hist['node_id']][$ccdtdate]."<br>";
					}
					
				} else {// Не первое событие в этом месяце, можно сравнить дату поднятия с датой падения

					if($cureventdate==$prev_event_date){
						
						if($mode=="debug") echo  "Падал в эту же дату. Лежал ".(strtotime ($mon_hist['event_date'])-strtotime ($prev_event_datetime))." сек<br>";// Если в 1 день
						$prostoi[$mon_hist['node_id']][$cureventdate]=$prostoi[$mon_hist['node_id']][$cureventdate]+(strtotime ($mon_hist['event_date'])-strtotime ($prev_event_datetime));
						if($mode=="debug") echo "Накопленный простой за $cureventdate равен ".$prostoi[$mon_hist['node_id']][$cureventdate];
					} else {//Падал не в эту дату, поднялся в эту дату
						if($mode=="debug") echo  "Падал не в эту дату, а ".$prev_event_date.". Лежал в общем счёте ".(strtotime ($mon_hist['event_date'])-strtotime ($prev_event_datetime))." сек<br>";
						
						// Рассчитываем простой за сегодня
						$prostoi[$mon_hist['node_id']][$cureventdate]=$prostoi[$mon_hist['node_id']][$cureventdate]+strtotime ($mon_hist['event_date'])-strtotime($cureventdate);
						if($mode=="debug") echo "Накопленный простой  за $cureventdate равен ".$prostoi[$mon_hist['node_id']][$cureventdate]."<br>";
						
						// Рассчитываем простой за дни между сегодня и датой падения
						for($ccdt=1;date("Y-m-d",strtotime ($mon_hist['event_date'])- 86400*$ccdt)>$prev_event_date;$ccdt++){//Идем вниз до даты падения не включая её
							
							$ccdtdate=date("Y-m-d",strtotime ($mon_hist['event_date'])- 86400*$ccdt);
							if($mode=="debug") echo "<br>";
							$prostoi[$mon_hist['node_id']][$ccdtdate]=86400; // Простой за эти даты равен 24 часа
							if($mode=="debug") echo "Накопленный простой за $ccdtdate равен ".$prostoi[$mon_hist['node_id']][$ccdtdate]."<br>";
							$lastccdtdate=$ccdtdate;
						}
						
						// Рассчитываем простой за дату падения
						if ($lastccdtdate) {//Поднялось не на следующий день
							//echo "Между датами были дни полного лежания<br>";
							$prostoi[$mon_hist['node_id']][$prev_event_date]=$prostoi[$mon_hist['node_id']][$prev_event_date]+(strtotime ($lastccdtdate)-strtotime ($prev_event_datetime));
						} else{//Поднялось на следующий день
							//echo "Между датами нет дней полного лежания<br>";
							$prostoi[$mon_hist['node_id']][$prev_event_date]=$prostoi[$mon_hist['node_id']][$prev_event_date]+(strtotime ($cureventdate)-strtotime ($prev_event_datetime));
						}
						if($mode=="debug") echo "Накопленный простой за $prev_event_date равен ".$prostoi[$mon_hist['node_id']][$prev_event_date];
					}
					
				}
				if($mode=="debug") echo "<br>";
			} elseif(($mon_hist['event']=="dead" and $newnode==1)or($prev_event="alive" and $mon_hist['event']=="dead")){
				if($mode=="debug"){
					//Выдаём сообщение
					if ($mon_hist['event']=="dead" and $newnode==1) echo "Первое событие в этом месяце - падение<br>";
					elseif($prev_event="alive" and $mon_hist['event']=="dead") echo  "Падение<br>";//Упал
				}
				// Если оно единственное событие или последнее событие за месяц в месяце, то добавляем простоев до конца месяца или до сегодняшней даты 
				if($mode=="debug") echo "Число событий за месяц ".$nod_count[$mon_hist['node_id']]." а это событие номер ".$act_count."<br>";
				if($nod_count[$mon_hist['node_id']]==$act_count){// Последнее событие  за месяц
					if($mode=="debug") echo "Это последнее событие в этом месяце<br>";
					$event_month=date("Y-m",strtotime ($mon_hist['event_date'])); // Месяц, в котором было событие
					$lastdayinmonth=date('Y-m-t',strtotime ($mon_hist['event_date'])); // Дата последнего числа в месяце, в котором было событие
					$current_month = date('Y-m'); // Реальный текущий месяц
					$current_date=date('Y-m-d'); // Реальная дата сегодня
					
					if($event_month==$current_month){//Месяц падения совпадает с текущим
						
						if($cureventdate==$current_date){// Определяем, если легло сегодня, то высчитываем простой до текущего времени
							$prostoi[$mon_hist['node_id']][$cureventdate]=$prostoi[$mon_hist['node_id']][$cureventdate]+(strtotime ("NOW")-strtotime ($mon_hist['event_date']));
							if($mode=="debug") echo "Последнее событие было сегодня<br>";
							if($mode=="debug") echo "Накопленный простой за $cureventdate (сегодня) равен ".$prostoi[$mon_hist['node_id']][$cureventdate]."<br>";
						
						} else{// Легло не сегодня, а в другой день, рассчитываем простой за предыдущие дни
													
							// Рассчитываем простой за сегодня
							$prostoi[$mon_hist['node_id']][$current_date]=$prostoi[$mon_hist['node_id']][$current_date]+strtotime ("NOW")-strtotime($current_date);
							if($mode=="debug") echo "Накопленный простой  за $current_date (сегодня) равен ".$prostoi[$mon_hist['node_id']][$current_date]."<br>";
							
							// Рассчитываем простой за дни между сегодня и датой падения
							for($ccdt=1;date("Y-m-d",strtotime ($current_date) - 86400*$ccdt)>date("Y-m-d",strtotime ($mon_hist['event_date']));$ccdt++){//Идем вниз до даты падения не включая её
								
								$ccdtdate=date("Y-m-d",strtotime ($current_date) - 86400*$ccdt);
								if($mode=="debug") echo "<br>";
								$prostoi[$mon_hist['node_id']][$ccdtdate]=86400; // Простой за эти даты равен 24 часа
								if($mode=="debug") echo "Накопленный простой за $ccdtdate равен ".$prostoi[$mon_hist['node_id']][$ccdtdate]."<br>";
								$lastccdtdate=$ccdtdate;
							}
							
							// Рассчитываем простой за дату падения
							if ($lastccdtdate) {//Поднялось не на следующий день
								if($mode=="debug") echo "Между датами были дни полного лежания<br>";
								$prostoi[$mon_hist['node_id']][$cureventdate]=$prostoi[$mon_hist['node_id']][$cureventdate]+(strtotime ($lastccdtdate)-strtotime ($mon_hist['event_date']));
							} else{//Поднялось на следующий день (сегодня)
								if($mode=="debug") echo "Между датами нет дней полного лежания<br>";
								$prostoi[$mon_hist['node_id']][$cureventdate]=$prostoi[$mon_hist['node_id']][$cureventdate]+(strtotime ($current_date)-strtotime ($mon_hist['event_date']));
							}
							if($mode=="debug") echo "Накопленный простой за $cureventdate равен ".$prostoi[$mon_hist['node_id']][$cureventdate];

						}
					} else{// Месяц падения не равен текущему
						
						if(date("Y-m-t",strtotime ($mon_month))==$cureventdate){// Упал в последний день месяца - date("t",strtotime ($mon_month));
							if($mode=="debug") echo "Рассчитываем с времени падения до конца текущего месяца<br>";
							$prostoi[$mon_hist['node_id']][$cureventdate]=$prostoi[$mon_hist['node_id']][$cureventdate]+(strtotime (date("Y-m",strtotime ($mon_month)+2678400))-strtotime ($mon_hist['event_date']));
							if($mode=="debug") echo "Накопленный простой за $cureventdate равен ".$prostoi[$mon_hist['node_id']][$cureventdate];
						}else {//Упал не в последний день месяца
							if($mode=="debug") echo "Упал не в последний день месяца<br>";
							// Определяем простой за все дни с конца месяца до даты падения, не включая ее
							for($ccdt=0;date("Y-m-d",strtotime ($lastdayinmonth) - 86400*$ccdt)>date("Y-m-d",strtotime ($mon_hist['event_date']));$ccdt++){//Идем вниз до даты падения не включая её
									
								$ccdtdate=date("Y-m-d",strtotime ($lastdayinmonth) - 86400*$ccdt);
								if($mode=="debug") echo "<br>";
								$prostoi[$mon_hist['node_id']][$ccdtdate]=86400; // Простой за эти даты равен 24 часа
								if($mode=="debug") echo "Накопленный простой за $ccdtdate равен ".$prostoi[$mon_hist['node_id']][$ccdtdate]."<br>";
								$lastccdtdate=$ccdtdate;
							}
							// Рассчитываем простой за дату падения
							if ($lastccdtdate) {//Поднялось не на следующий день
								if($mode=="debug") echo "Между датами были дни полного лежания<br>";
								$prostoi[$mon_hist['node_id']][$cureventdate]=$prostoi[$mon_hist['node_id']][$cureventdate]+(strtotime ($lastccdtdate)-strtotime ($mon_hist['event_date']));
							} else{//Рассчитываем с даты падения до конца месяца
								if($mode=="debug") echo "Рассчитываем с даты падения до конца месяца<br>";
								$prostoi[$mon_hist['node_id']][$cureventdate]=$prostoi[$mon_hist['node_id']][$cureventdate]+(strtotime ($current_date)-strtotime ($mon_hist['event_date']));
							}
							if($mode=="debug") echo "Накопленный простой за $cureventdate равен ".$prostoi[$mon_hist['node_id']][$cureventdate];
						}
					}
				}
			} else if($mode=="debug") echo "<b>".$mon_hist['event_date']." - непредвиденное событие</b><br>";

			$prev_node_id=$mon_hist['node_id'];// Узел предыдущего события
			$prev_event_datetime=$mon_hist['event_date'];// Время предыдущего события
			$prev_event_date=$cureventdate;// Дата предыдущего события
			$prev_event=$mon_hist['event'];// Тип предыдущего события
			$newnode=0;
		}
		// Еще обработать когда событий на узле за этот месяц не было!!!!!

		if($mon_nodes_script=process_data($_REQUEST['someid3'],50)){ # Есть скрипт для обработки простоев
		
			include($_SERVER["DOCUMENT_ROOT"]."/project/".$projectname."/scripts/".$mon_nodes_script);
		
		} else{	# Выводим все простои 
			foreach($mon_node as $node_id){
				echo $hostname[$node_id]."<br>";
				for($mon_i=1;$mon_i<=date("t",strtotime ($mon_month));$mon_i++){
					
					if($mon_i<10) {$mon_day="0".$mon_i;}
					else $mon_day=$mon_i;			
					
					?><a style="color:white" title="<?if(!$prostoi[$node_id][date("Y-m-$mon_day",strtotime ($mon_month))]){echo "Простоя не было";}
					else {# Сообщаем величину простоя
						echo date("Y-m-$mon_day",strtotime ($mon_month))." простой составил ";
						if($prostoi[$node_id][date("Y-m-$mon_day",strtotime ($mon_month))]<$yellow_zone_time*60*60) echo "менее ".ceil($prostoi[$node_id][date("Y-m-$mon_day",strtotime ($mon_month))]/60)." мин";
						else echo ($prostoi[$node_id][date("Y-m-$mon_day",strtotime ($mon_month))]/60)." мин";
					}
					?>" class="small button <?
					if(!$prostoi[$node_id][date("Y-m-$mon_day",strtotime ($mon_month))]) {?>green<?}
					elseif ($prostoi[$node_id][date("Y-m-$mon_day",strtotime ($mon_month))]<$yellow_zone_time*60*60){?>yellow<?}
					else {?>red<?}
					
					?>"><?=$mon_i;?></a><?
				}
				echo "<br><br>";
			}
			?><a style="color:white" class="small button green">1</a> - простой не обнаружен<br>
			<a style="color:white" class="small button yellow">1</a> - простой составил менее <?=$yellow_zone_time?> минут<br>
			<a style="color:white" class="small button red">1</a> - простой составил более <?=$yellow_zone_time?> минут<br><?
			/*?></table><?*/
		}
	} elseif($_REQUEST['action']=="get_mon_hist4date"){ #Все события по дате
		
		insert_function("process_user_data");
		# Узлы для вывода
		$mon_nodes_req=process_data($_REQUEST['someid1'],150);//ID нодов для вывода через запятую
		$mon_node=explode(",",$mon_nodes_req);
		
		if(count($mon_node)>1){
			
			foreach($mon_node as $mon_node_id){
				$nodes_sql.="ev.`node_id`=".$mon_node_id." or ";
				$nodes_name_sql.="`node_id`=".$mon_node_id." or ";
				
			}
			$nodes_sql="(".substr($nodes_sql,0,-4).")";
			$nodes_name_sql="(".substr($nodes_name_sql,0,-4).")";
			
		} elseif(count($mon_node)==1 and !$mon_node[0]==''){
			$nodes_sql="ev.`node_id`=".$mon_node[0];
			$nodes_name_sql="`node_id`=".$mon_node[0];
			
		} else {echo "Не выбран узел для вывода истории";exit();}
		
		# Месяц для вывода
		$mon_date=process_data($_REQUEST['someid2'],20);//День для вывода
		
		#Хостнеймы отдельно
		$mon_hosts_q=mysql_query("SELECT * FROM `$moduletableprefix-monitor-nodes` WHERE $nodes_name_sql ;");
		while($mon_hosts=mysql_fetch_array($mon_hosts_q)){
			$hostname[$mon_hosts['node_id']]=$mon_hosts['hostname_'.$language];
		}
		# История

		$day_hist_qt="SELECT * FROM `$moduletableprefix-monitor-events` ev,`$tableprefix-monitor-nodes` n WHERE n.`node_id`=ev.`node_id` and $nodes_sql and `event_date` BETWEEN '$mon_date 00:00:00' AND '$mon_date 23:59:59' ORDER BY ev.`node_id` ASC , `event_date` ASC;";
		$day_hist_q=mysql_query($day_hist_qt);
		
		while($day_hist=mysql_fetch_array($day_hist_q)){
			if($prev_node_id!==$day_hist['node_id'] or !$prev_node_id){// Новый узел и строчки для него есть
				//$newnode=1;
				if($mode=="debug") echo "<br><br>".$day_hist['hostname_'.$language]." (".$day_hist['node_id'].")<br><br>";
				if($prev_event)	unset($prev_event,$prev_event_date); // Обновляем данные
				$act_count=0; // Порядковый номер события в этом месяце для данного узла
				?><b><?=$day_hist['hostname_'.$language]?></b><br><?
			}
			$act_count++; // Обновили порядковый номер события
			?><img src="/files/simplicio/direction_<?
			if($day_hist['event']=="dead") echo "down";
			elseif($day_hist['event']=="alive") echo "up";
			?>.png" class="imgmiddle"> <?=$day_hist['event_date']."<br>";
			
			
			
			
			$prev_node_id=$day_hist['node_id'];// Узел предыдущего события
			//$prev_event_datetime=$day_hist['event_date'];// Время предыдущего события
			//$prev_event_date=$cureventdate;// Дата предыдущего события
			$prev_event=$mon_hist['event'];// Тип предыдущего события
			//$newnode=0;
		}
	
	
	
	
	
	
	
	
	
	} elseif($_REQUEST['action']=="start_daemon"){ #Запуск демона из админки
		$mon_node=process_data($_REQUEST['someid1'],3);
		
		$mon_host_info=mysql_fetch_array(mysql_query("SELECT * FROM `$moduletableprefix-monitor-nodes` WHERE `node_id`='$mon_node' LIMIT 0,1;"));
		if($mon_host_info['node_id']){ #Запускаем демона
			if(!$mon_host_info['port']) $mon_host_info['port']=0;// Для пингов и других служб
			
			
			
			# Переделать в БД!!!!!!!!
			define(PIDFILE_NAME, $_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/".$mon_host_info['mon_type']. str_replace ('.' , '' ,$mon_host_info['ipaddr']) . $mon_host_info['port']. "every". $mon_host_info['mon_period']. '.pid');


			if (is_readable(PIDFILE_NAME)) { #Файл найден
				$pid = (int)file_get_contents(PIDFILE_NAME);

				if ($pid > 0 && posix_kill($pid, 0)) {# Такой демон найден и запущен
					$log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | New worker NOT started in daemon mode because process is already running with PID =".$pid);
					echo sitemessage("$modulename",'deamon_alr_run');
					exit;
				}

				if (!unlink(PIDFILE_NAME)) {# Файл найден, но демон не найден. Стираем файл с PID
					$log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | Attention. PID-file delete can NOT be erased");
					echo sitemessage("$modulename",'PIDfile_cant_erase');
					exit;
				}
			}
			
			
			
			if($mon_host_info['mon_type']=="ping" or $mon_host_info['mon_type']=="fsockopen" or $mon_host_info['mon_type']=="Socket") {
				$cons_cmd="php ".$fullpath."modules/".$modulename."/monitor_worker.php ".$projectname." ".$mon_host_info['ipaddr']." ".$mon_host_info['port']." ".$mon_host_info['mon_type']." ".$mon_host_info['mon_period']." > /dev/null &";
				exec($cons_cmd);
				echo sitemessage("$modulename",'daemon_started');
				$log->LogInfo(basename (__FILE__)." | Daemon for node ".$mon_node." successfully started with PID ".$pid);
			}
		} else {
			$log->LogInfo(basename (__FILE__)." | Daemon for node ".$mon_node." have NOT been started, there is no that node_id");
		}
	} elseif($_REQUEST['action']=="stop_daemon"){ #Останов демона из админки (ДОДЕЛАТЬ)
		$mon_node=process_data($_REQUEST['someid1'],3);
		$log->LogInfo(basename (__FILE__)." | Stop daemon for node ".$mon_node);
		$mon_host_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-monitor-nodes` WHERE `node_id`='$mon_node' LIMIT 0,1;"));
		if($mon_host_info['last_pid']){ #Останавливаем демона
			//if($mon_host_info['mon_type']=="ping" or $mon_host_info['mon_type']=="fsockopen" or $mon_host_info['mon_type']=="Socket") $last_line=exec("php ".$fullpath."modules/".$modulename."/monitor_worker.php ".$projectname." ".$mon_host_info['ipaddr']." ".$mon_host_info['port']." ".$mon_host_info['mon_type']." ".$mon_host_info['mon_period']." > /dev/null &");
			//echo($last_line);
			exec ("kill -9 ".$mon_host_info['last_pid']);
			#Стираем PID-файл демона
			
		}
	}
}?>