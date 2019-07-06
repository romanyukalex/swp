<?
$log->LogInfo(basename (__FILE__)." | ".(__LINE__)." | Got ".(__FILE__)); 
if ($nitka=="1"){
	
	//var_dump(debug_backtrace(1));
	$prev_script=debug_backtrace(1); // Трейс вызова
	
	if(strpos($prev_script[0]['file'],"cron.php")){//Запуск из крона
		var_dump($changed_statuses);
		# Оформляем событие всего инстанса в фиктивный узел 17
		if($changed_statuses[1]){ // Изменился статус внешнего адреса сервиса, проверяем, что случилось
		
			if($changed_statuses[7]){ // Изменился статус сетевого стека
				echo "Network status changed to ".$changed_statuses[2].PHP_EOL;
				$cst_upd_q=mysql_query("UPDATE `$tableprefix-monitor-nodes` SET `cur_status` = '".$changed_statuses[7]."' WHERE `node_id` = '17';");
				$evhist_q=mysql_query("INSERT INTO `$tableprefix-monitor-events` 
				(`event_id` ,`node_id` ,`event` ,`event_date` ,`comment` ) VALUES 
				(NULL , '17', '".$changed_statuses[7]."', CURRENT_TIMESTAMP , '7' );");
				$log->LogDebug($modulename."/cron | ".(__LINE__)." | SN RusAgro status changed to ".$changed_statuses[7]);
			} elseif($changed_statuses[9]){ //Изменился статус ext-адреса балансировщика
				echo "Balanser ext status changed to ".$changed_statuses[2].PHP_EOL;
				if($changed_statuses[8]){//Изменился статус всего балансировщика
					echo "Balanser int status changed to ".$changed_statuses[2].PHP_EOL;
					$cst_upd_q=mysql_query("UPDATE `$tableprefix-monitor-nodes` SET `cur_status` = '".$changed_statuses[8]."' WHERE `node_id` = '17';");
					$evhist_q=mysql_query("INSERT INTO `$tableprefix-monitor-events` 
					(`event_id` ,`node_id` ,`event` ,`event_date` ,`comment` ) VALUES 
					(NULL , '17', '".$changed_statuses[8]."', CURRENT_TIMESTAMP , '8' );");
				} else { //Изменился статус только внешнего адреса
					$cst_upd_q=mysql_query("UPDATE `$tableprefix-monitor-nodes` SET `cur_status` = '".$changed_statuses[9]."' WHERE `node_id` = '17';");
					$evhist_q=mysql_query("INSERT INTO `$tableprefix-monitor-events` 
					(`event_id` ,`node_id` ,`event` ,`event_date` ,`comment` ) VALUES 
					(NULL , '17', '".$changed_statuses[9]."', CURRENT_TIMESTAMP , '9' );");
				}
				$log->LogDebug($modulename."/cron | ".(__LINE__)." | SN RusAgro status changed to ".$changed_statuses[9]);
			} elseif(($changed_statuses[10]=="alive" and $changed_statuses[11]=="alive" and $changed_statuses[11]=="alive" and $changed_statuses[12]=="alive" 
				and $changed_statuses[13]=="alive" and $changed_statuses[14]=="alive" and $changed_statuses[15]=="alive" and $changed_statuses[16]=="alive") or
				($changed_statuses[10]=="dead" and $changed_statuses[11]=="dead" and $changed_statuses[11]=="dead" and $changed_statuses[12]=="dead" 
				and $changed_statuses[13]=="dead" and $changed_statuses[14]=="dead" and $changed_statuses[15]=="dead" and $changed_statuses[16]=="dead")){
				// Случай падения или восстановления всех нодов сервиса одновременно
				echo "All SN nodes status changed to ".$changed_statuses[10].PHP_EOL;
				$cst_upd_q=mysql_query("UPDATE `$tableprefix-monitor-nodes` SET `cur_status` = '".$changed_statuses[10]."' WHERE `node_id` = '17';");
				$evhist_q=mysql_query("INSERT INTO `$tableprefix-monitor-events` 
					(`event_id` ,`node_id` ,`event` ,`event_date` ,`comment` ) VALUES 
					(NULL , '17', '".$changed_statuses[10]."', CURRENT_TIMESTAMP , 'Все ноды SN в статусе ".$changed_statuses[10]."' );");
				$log->LogDebug($modulename."/cron | ".(__LINE__)." | SN RusAgro status changed to ".$changed_statuses[10]." because all nodes became ".$changed_statuses[10]);
			} elseif($changed_statuses[10] or $changed_statuses[11] or $changed_statuses[11] or $changed_statuses[12] 
				or $changed_statuses[13] or $changed_statuses[14] or $changed_statuses[15] or $changed_statuses[16]){
				// Случай падения или восстановления одного из нодов сервиса требует проверки состояния всех остальных нодов
				echo "One or more (but not all) SN node status changed ".PHP_EOL;
				
				$ot_nod_q=mysql_query("SELECT * FROM `$tableprefix-monitor-nodes` WHERE `mon_status`='active' 
				and (`node_id`='10' or `node_id`='11' or `node_id`='12' or `node_id`='13' or `node_id`='14' or `node_id`='15' or `node_id`='16');");//Узлы для мониторинга на сей момент
				while($ot_nod_status=mysql_fetch_array($ot_nod_q)){
					if($ot_nod_status['cur_status']=="dead") $dead_nodes++;
					elseif($ot_nod_status['cur_status']=="alive") $alive_nodes++;
				}
				if($dead_nodes==mysql_num_rows($ot_nod_q)){// Последний узел, видимо, умер только что
					$cst_upd_q=mysql_query("UPDATE `$tableprefix-monitor-nodes` SET `cur_status` = 'dead' WHERE `node_id` = '17';");
					$evhist_q=mysql_query("INSERT INTO `$tableprefix-monitor-events` 
					(`event_id` ,`node_id` ,`event` ,`event_date` ,`comment` ) VALUES 
					(NULL , '17', 'dead', CURRENT_TIMESTAMP , 'All SN nodes are dead' );");
					$log->LogDebug($modulename."/cron | ".(__LINE__)." | SN RusAgro status changed to dead because all nodes are dead right now");
				} elseif($alive_nodes>0){//Какие то узлы ожили только что
					$cst_upd_q=mysql_query("UPDATE `$tableprefix-monitor-nodes` SET `cur_status` = 'alive' WHERE `node_id` = '17';");
					$evhist_q=mysql_query("INSERT INTO `$tableprefix-monitor-events` 
					(`event_id` ,`node_id` ,`event` ,`event_date` ,`comment` ) VALUES 
					(NULL , '17', 'alive', CURRENT_TIMESTAMP , 'One or more SN nodes are alive' );");
					$log->LogDebug($modulename."/cron | ".(__LINE__)." | SN RusAgro status changed to alive because one or more nodes are alive right now");
				}
			} elseif($changed_statuses[2]){ //Изменился статус БД SN-инстанса
				echo "Database status changed to ".$changed_statuses[2].PHP_EOL;
				$cst_upd_q=mysql_query("UPDATE `$tableprefix-monitor-nodes` SET `cur_status` = '".$changed_statuses[2]."' WHERE `node_id` = '17';");
				$evhist_q=mysql_query("INSERT INTO `$tableprefix-monitor-events` 
				(`event_id` ,`node_id` ,`event` ,`event_date` ,`comment` ) VALUES 
				(NULL , '17', '".$changed_statuses[2]."', CURRENT_TIMESTAMP , '2' );");
				$log->LogDebug($modulename."/cron | ".(__LINE__)." | SN RusAgro status changed to ".$changed_statuses[2]);
			//} elseif($changed_statuses[2]){ //Лег DNS
			
			} else { //Изменился статус внешнего доступа по неизвестной причине
				$log->LogDebug($modulename."/cron | ".(__LINE__)." | SN RusAgro status do NOT changed because reason is unknown");
			}
		}
	}elseif(strpos($prev_script[0]['file'],"ajax.php")){ //Вызов отображения простоев
		
		#Получим статистику по временам
		$SLA_mon_q=mysql_query("SELECT * FROM `$tableprefix-SN_SLA` WHERE `company_id`='$company_id' order by `date` ASC");
		while($SLA_mon=mysql_fetch_array($SLA_mon_q)){
			echo $SLA_mon['browser_time'];
		
		}
		# Выводим все простои узла 17 
		for($mon_i=1;$mon_i<=date("t",strtotime ($mon_month));$mon_i++){
			
			if($mon_i<10) {$mon_day="0".$mon_i;}
			else $mon_day=$mon_i;			
			$cur_day=date("Y-m-$mon_day",strtotime ($mon_month));
			?><a style="color:white" title="<?if(!$prostoi[17][$cur_day]){echo "Простоя не было";}
			else {# Сообщаем величину простоя
				echo $cur_day." простой составил ";
				
				echo ($prostoi[17][$cur_day]/60)." мин";
			}
			?>" class="small button <?
			if(!$prostoi[17][$cur_day]) {?>green<?}
			else {?>red<?}
			
			?>"onclick="open_downtime_details('<?=$cur_day?>')"><?=$mon_i;?></a><?
		}
		echo "<br><br>";
	
		?><a style="color:white" class="small button green">1</a> - простой не обнаружен<br>
		<a style="color:white" class="small button red">1</a> - простой обнаружен<br>
		<div id="node_hist_ap"></div>
		<script>
		function open_downtime_details(mon_date){
			ajax_req('ping_and_portmon','get_mon_hist4date','node_hist_ap','2,7,8,9,10,11,12,13,14,15,16',mon_date);
		}
		</script>
		<style>
		#node_hist_ap img{height:20px}
		</style>
		
		
		<?

	}
	
	
	/*
	
	for($mon_i=1;$mon_i<=date("t",strtotime ($mon_month));$mon_i++){
		if($prostoi[7][$mon_i]){ #Недоступны сетевые элементы, нет интернет
			$main_downtime[$mon_i]=$prostoi[7][$mon_i];
		}
*/
	
}?>