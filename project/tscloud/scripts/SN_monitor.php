<?
/*
1 Доступность услуги (в целом)
	
Сервис считается недоступным, если недоступен весь путь до ServiceNow из интернета. Проверять договорились так: мы запрашиваем доступность SN с использованием внешнего IP. Таким образом траффик пойдет через сетевые элементы, через балансировщик на ноды и БД SN
	
Полная недоступность может случиться по следующим причинам:
	- недоступны сетевые элементы ASR+ASA (будем проверять доступностью 8.8.8.8 из нашей сети)
	- недоступен балансировщик (будем проверять по доступности 172.31.254.24:80)
	- недоступен DNS (будем проверять, пингуя 10 хостов в интернете, по 1 хосту раз в минуту, чтобы исключить использование локального кеша DNS и гарантировать обращение к нашему DNS при каждой проверке)
	- недоступны ноды SN (будем проверять доступностью IP+порт каждой ноды) 
	- недоступна БД SN  (будем проверять доступностью IP+порт каждой ноды) 
	

2 Время генерации и доставки страницы

Время генерации страницы на сервере (мс) 
Время генерации страницы на клиенте (мс) 
Время доставки страницы по сети (мс) 

Стучим на
https://rusagro.ts-cloud.ru/rusagro/clean%20login.do
Логинимся
test_cloud
a123456!
Вынимаем усредненное с:
https://rusagro.ts-cloud.ru/api/now/stats/syslog_transaction?sysparm_limit=10&sysparm_query=client_transaction=true^sys_created_onBETWEEN@javascript:gs.dateGenerate('2015-10-14','00:00:00')@javascript:gs.dateGenerate('2015-10-14','23:59:59')@javascript:gs.daysAgoStart(0)@javascript:gs.daysAgoEnd(0)^sys_created_by=test_cloud&sysparm_avg_fields=client_response_time,client_network_time,browser_time
Под ним же
test_cloud
a123456!






Балансировщик:
IP: 95.163.143.19 (172.31.254.24)

Сервер БД:
IP:172.31.254.37 

Сервер APP:
IP:172.31.254.36 

Что касается мониторинга самих нод,  то их  сейчас  семь, но через некоторое время может стать совершенно другое количество.  Их локация и IP адреса могут меняться. Самое простое, это парсить   вывод статистики балансировщика, а именно список Backend, там указано, какие ноды сейчас работают и по каких портам.

Посмотреть как выглядит статистика балансировщика можно тут https://rusagro.ts-cloud.ru/SdfrFDx67Derfss [rusagro:Ru$@gR0] 

*/
$log->LogInfo(basename (__FILE__)." | ".(__LINE__)." | Got ".(__FILE__)); 
if ($nitka=="1"){

	?><tr><td>Статус инстанса</td><td><b>:</b></td>
		<td>
		База данных (из ServiceNOW):<span id="sn_db_check_ap">Загрузка</span><br>
		<? 
		//Production
		?>Пинг сервера приложений:<? insert_module("ping_and_portmon","ping","172.31.254.36");
		?><br>Пинг базы данных:<?
		insert_module("ping_and_portmon","ping","172.31.254.37");
		?><br>Почтовый сервер (port 25):<?
		insert_module("ping_and_portmon","fsockopen","mail.ts-cloud.ru","25");
		?>
		<br>
		</td>
	</tr>
	<tr>
		<td>
	История доступности<br>
		</td>
		<td><b>:</b></td>
		<td><? //echo substr($subscriptionslist['creations_ts'],0,7); 
			//$curmonth=date("Y-m");
			//echo date("Y-m",strtotime("-1 months"));
			?>
		<form>
			<select name="mon_hist_month" id="mon_hist_month" onChange="get_monitor_history('2,7,8,9,10,11,12,13,14,15,16,17');">
				<? 
				$gd=0;
				
				while(date("Y-m",strtotime("-".$gd." months"))>=substr($subscriptionslist['creations_ts'],0,7)){
					?><option value="<?=date("Y-m",strtotime("-".$gd." months"))?>"><?=date("Y-m",strtotime("-".$gd." months"))?></option><?
					$gd++;	
				}?>
			</select>
		</form>
		<div id="hist_table"></div>
		<script>
		function get_monitor_history(nodes){
			var mon_month = document.getElementById('mon_hist_month').value;
			ajaxreq(nodes,mon_month,'get_mon_history','hist_table','ping_and_portmon','downtime_SN.php');
		}

		get_monitor_history('2,7,8,9,10,11,12,13,14,15,16,17');
		ajaxreq('https://rusagro.ts-cloud.ru/stats.do','',"check_SN_DB","sn_db_check_ap","project_script");
		</script>
		<br>
		</td>
	</tr>
	<tr><td>Доступность Сервиса</td><td><b>:</b></td>
	
	<td>
	<form>
			<select name="mon_hist_month" id="mon_hist_month">
				<? 
				$gd=0;
				
				while(date("Y-m",strtotime("-".$gd." months"))>=substr($subscriptionslist['creations_ts'],0,7)){
					?><option value="<?=date("Y-m",strtotime("-".$gd." months"))?>"><?=date("Y-m",strtotime("-".$gd." months"))?></option><?
					$gd++;	
				}?>
			</select>
	
			<select name="mon_hist_month" id="mon_hist_month">
				<? 
				$gd=0;
				
				while(date("Y-m",strtotime("-".$gd." months"))>=substr($subscriptionslist['creations_ts'],0,7)){
					?><option value="<?=date("Y-m",strtotime("-".$gd." months"))?>"><?=date("Y-m",strtotime("-".$gd." months"))?></option><?
					$gd++;	
				}?>
			</select>
			<button name="button" value="OK" type="button">Ок</button>

		</form>
	<?
		$months_array = array(1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь');
		
		function K_got($dur,$t)
		{
			return ($dur*24*60*60 - $t)*100/($dur*24*60*60);;
		}
		//echo $SLA_date1;
		$SLA_start_date = "2016-01-01";
		$SLA_stop_date = date("Y-m-d",time());
		//$SLA_stop_date = '2016-07-31';
		$time = 60;
		//echo date('i:s', $time);
		$id_month_start_SLA = date_parse($SLA_start_date);
		$id_month_stop_SLA = date_parse($SLA_stop_date);
		//echo $id_month_start_SLA['month'];
		$K_norm_SLA = 99.95;
		$date1111 = new DateTime($SLA_start_date); 
		$date2111 = new DateTime($SLA_stop_date);
		$interval = $date1111->diff($date2111);
		//Расчет разницы двух дат
		$years = $interval->format('%y');
		$months = $interval->format('%m');
		$days = $interval->format('%d');
		$during_m1 = $interval->format('%a');
		
		//print_r($interval);?><br><?
		//print_r($months);?><br><?
		//print_r($days);?><br><?
		//print_r($during);
		if ($months <= 1){
			$t_soft = 0; $t_net = 0;
			$SLA_array_event_query = mysql_query("select `oos_object`,`date`,`time` FROM `tscloud-monitor-outofservice` where `date` between '$SLA_start_date' and '$SLA_stop_date';");
			while($table_list_arr_body_m[]=mysql_fetch_array($SLA_array_event_query))
			$table_list_arr_body_m1[] = end($table_list_arr_body_m);
			//print_r($table_list_arr_body_m1);
			foreach($table_list_arr_body_m1 as $v1_SLA){
				if ($v1_SLA['oos_object'] == "soft"){
					$t_soft = $t_soft + intval($v1_SLA['time']);					
				}
				elseif ($v1_SLA['oos_object'] == "net"){
					$t_net = $t_net + intval($v1_SLA['time']);					
				}
			}

			$t_common = $t_soft + $t_net;
			$K_commmon = K_got($during_m1,$t_common);
			$K_SOFT = K_got($during_m1,$t_soft);
			$K_NET= K_got($during_m1,$t_net);
			?>
			
				<table border = "1">
				<tr><td colspan="4"><?echo $months_array[$id_month_start_SLA['month']]?></td></tr>
				<tr><td rowspan="2" width="300">Параметр</td><td colspan="2"width="450">Коэффициент готовности</td><td rowspan="2" width="150">Время простоя</td></tr>
				<tr><td bordercolor="black">Факт.</td><td>Норм.</td></tr>
				<tr><td>Доступность услуги (в целом)</td><td><p><font color=<?if($K_norm_SLA > $K_commmon){?>red<?} ?>><? echo number_format($K_commmon,5);?></font></p></td><td><? echo number_format($K_norm_SLA,5);?></td><td><?echo $t_common;?></td></tr>
				<tr><td>Доступность ПО</td><td><p><font color=<?if($K_norm_SLA > $K_SOFT){?>red<?} ?>><? echo number_format($K_SOFT,5);?></font></p></td><td><? echo number_format($K_norm_SLA,5);?></td><td><?echo $t_soft;?></td></tr>
				<tr><td>Доступность сети</td><td><p><font color=<?if($K_norm_SLA > $K_NET){?>red<?} ?>><? echo number_format($K_NET,5);?></font></p></td><td><? echo number_format($K_norm_SLA,5);?></td><td><?echo $t_net;?></td></tr>
				</table>
				
				
				<?	

		}
		elseif (($months < 3) || (($months == 1 && $days >= 1) && ($months == 1 && $days <= 30))) {
			echo "2 months";
			$t_soft_1 = 0; $t_soft_2 = 0;
			$t_net_1 = 0; $t_net_2 = 0;
			$SLA_array_event_query = mysql_query("select `oos_object`,`date`,`time` FROM `tscloud-monitor-outofservice` where `date` between '$SLA_start_date' and '$SLA_stop_date';");
			while($table_list_arr_body_m[]=mysql_fetch_array($SLA_array_event_query))
			$table_list_arr_body_m2[] = end($table_list_arr_body_m);
			//print_r($table_list_arr_body_m2);
			$d = new DateTime( $SLA_start_date );
			$d->modify( 'first day of next month' );
			$SLA_between_date = $d->format( 'Y-m-d' );
			$id_month_between_SLA = date_parse($SLA_between_date);
			foreach($table_list_arr_body_m2 as $v2_SLA){
				if ( $v2_SLA['oos_object'] == "soft" and (strtotime($v2_SLA['date']) < strtotime($SLA_between_date) and strtotime($v2_SLA['date']) >= strtotime($SLA_start_date)) ){
					$t_soft_1 = $t_soft_1 + intval($v2_SLA['time']);				
				}
				elseif ( $v2_SLA['oos_object'] == "soft" and (strtotime($v2_SLA['date']) >= strtotime($SLA_between_date) and strtotime($v2_SLA['date']) < strtotime($SLA_stop_date)-1) ){
					$t_soft_2 = $t_soft_2 + intval($v2_SLA['time']);		
				}
				elseif ( $v2_SLA['oos_object'] == "net" and (strtotime($v2_SLA['date']) < strtotime($SLA_between_date) and strtotime($v2_SLA['date']) >= strtotime($SLA_start_date)) ){
					$t_net_1 = $t_net_1 + intval($v2_SLA['time']);				
				}
				elseif ( $v2_SLA['oos_object'] == "net" and (strtotime($v2_SLA['date']) >= strtotime($SLA_between_date) and strtotime($v2_SLA['date']) < strtotime($SLA_stop_date)-1) ){
					$t_net_2 = $t_net_2 + intval($v2_SLA['time']);				
				}
			}
			$t_soft = $t_soft_1 + $t_soft_2;
			$t_net = $t_net_1 + $t_net_2;
			$t_common_1 = $t_soft_1 + $t_net_1;
			$t_common_2= $t_soft_2 + $t_net_2;
			$t_common = $t_soft + $t_net;

			$date_m2_1 = new DateTime($SLA_start_date); 
			$date_m2_2 = new DateTime($SLA_between_date);
			$date_m2_3  = new DateTime($SLA_stop_date);
			$interval_1 = $date_m2_1->diff($date_m2_2);
			$interval_2 = $date_m2_2->diff($date_m2_3);
			$interval_m2 = $date_m2_1->diff($date_m2_3);
			$years_m2_1 = $interval_1->format('%y');
			$months_m2_1 = $interval_1->format('%m');
			$days_m2_1 = $interval_1->format('%d');
			$during_m2_1 = $interval_1->format('%a');
			$during_m2 = $interval_m2->format('%a');
			$years_m2_2 = $interval_2->format('%y');
			$months_m2_2 = $interval_2->format('%m');
			$days_m2_2 = $interval_2->format('%d');
			$during_m2_2 = $interval_2->format('%a');
			

			$K_commmon_1= K_got($during_m2_1,$t_common_1);
			$K_commmon_2= K_got($during_m2_2,$t_common_2);
			$K_commmon = K_got($during_m2,$t_common);
			$K_NET_1= K_got($during_m2_1,$t_net_1);
			$K_NET_2= K_got($during_m2_2,$t_net_2);
			$K_NET= K_got($during_m2,$t_net);
			
			$K_SOFT_1= K_got($during_m2_1,$t_soft_1);
			$K_SOFT_2= K_got($during_m2_2,$t_soft_2);
			$K_SOFT= K_got($during_m2,$t_soft);
			
			//print_r($table_list_arr_body_m2[0]);
			
			
			?>
			<table border = "1">
				<tr><td></td><td colspan="3"><?echo $months_array[$id_month_start_SLA['month']];?></td><td colspan="3"><?echo $months_array[$id_month_between_SLA['month']];?></td><td colspan="3">Итог</td></tr>
				<tr><td rowspan="2">Параметры</td><td colspan="2">Коэффициент готовности</td><td rowspan="2">Время простоя</td><td colspan="2">Коэффициент готовности</td><td rowspan="2">Время простоя</td><td colspan="2">Коэффициент готовности</td><td rowspan="2">Время простоя</td></tr>
				<tr><td>Факт.</td><td>Норм.</td><td>Факт.</td><td>Норм.</td><td>Факт.</td><td>Норм.</td></tr>
				<tr><td>Доступность услуги (в целом)</td><td><p><font color=<?if($K_norm_SLA > $K_commmon_1){?>red<?} ?>><? echo number_format($K_commmon_1,5);?></font></p></td><td><? echo number_format($K_norm_SLA,5);?></td><td><?echo $t_common_1;?></td><td><p><font color=<?if($K_norm_SLA > $K_commmon_2){?>red<?} ?>><? echo number_format($K_commmon_2,5);?></font></p></td><td><? echo number_format($K_norm_SLA,5);?></td><td><?echo $t_common_2;?></td><td><p><font color=<?if($K_norm_SLA > $K_commmon){?>red<?} ?>><? echo number_format($K_commmon,5);?></font></p></td><td><? echo number_format($K_norm_SLA,5);?></td><td><?echo $t_common;?></td></tr>
				<tr><td>Доступность ПО</td><td><p><font color=<?if($K_norm_SLA > $K_SOFT_1){?>red<?} ?>><? echo number_format($K_SOFT_1,5);?></font></p></td><td><? echo number_format($K_norm_SLA,5);?></td><td><?echo $t_soft_1;?></td><td><p><font color=<?if($K_norm_SLA > $K_SOFT_2){?>red<?} ?>><? echo number_format($K_SOFT_2,5);?></font></p></td><td><? echo number_format($K_norm_SLA,5);?></td><td><?echo $t_soft_2;?></td><td><p><font color=<?if($K_norm_SLA > $K_SOFT){?>red<?} ?>><? echo number_format($K_SOFT,5);?></font></p></td><td><? echo number_format($K_norm_SLA,5);?></td><td><?echo $t_soft;?></td></tr>
				<tr><td>Доступность сети</td><td><p><font color=<?if($K_norm_SLA > $K_NET_1){?>red<?} ?>><? echo number_format($K_NET_1,5);?></font></p></td><td><? echo number_format($K_norm_SLA,5);?></td><td><?echo $t_net_1;?></td><td><p><font color=<?if($K_norm_SLA > $K_NET_2){?>red<?} ?>><? echo number_format($K_NET_2,5);?></font></p></td><td><? echo number_format($K_norm_SLA,5);?></td><td><?echo $t_net_2;?></td><td><p><font color=<?if($K_norm_SLA > $K_NET){?>red<?} ?>><? echo number_format($K_NET,5);?></font></p></td><td><? echo number_format($K_norm_SLA,5);?></td><td><?echo $t_net;?></td></tr>
			</table>
			<?
		}
		
		elseif ( ($months == 2 && $days >= 2 )or($months >= 3) ) {
			//echo "3 months";
			$t_soft_1 = 0; $t_soft_2 = 0; $t_soft_3 = 0; $t_soft = 0;
			$t_net_1 = 0; $t_net_2 = 0; $t_net_3 = 0; $t_net = 0;
			$SLA_array_event_query = mysql_query("select `oos_object`,`date`,`time` FROM `tscloud-monitor-outofservice` where `date` between '$SLA_start_date' and '$SLA_stop_date';");
			while($table_list_arr_body_m[]=mysql_fetch_array($SLA_array_event_query))
			$table_list_arr_body_m3[] = end($table_list_arr_body_m);
			//print_r($table_list_arr_body_m3);
			$d1 = new DateTime( $SLA_stop_date );
			$d1->modify( 'first day of this month' );
			$SLA_between_date_1 = $d1->format( 'Y-m-d' );
			//print_r($SLA_between_date_1);
			$d2 = new DateTime( $SLA_between_date_1 );
			$d2->modify( 'first day of last month' );
			$SLA_between_date_2 = $d2->format( 'Y-m-d' );
			//print_r($SLA_between_date_2);
			$d3 = new DateTime( $SLA_between_date_2 );
			$d3->modify( 'first day of last month' );
			$SLA_between_date_3 = $d3->format( 'Y-m-d' );
			//print_r($SLA_between_date_3);
			
			$id_month_between_SLA_1 = date_parse($SLA_between_date_1);
			$id_month_between_SLA_2 = date_parse($SLA_between_date_2);
			$id_month_between_SLA_3 = date_parse($SLA_between_date_3);

			
			//Calculate of 3 last months t_soft and t_net
			foreach($table_list_arr_body_m3 as $v3_SLA){

				
				if ( $v3_SLA['oos_object'] == "soft" and (strtotime($v3_SLA['date']) < strtotime($SLA_between_date_2) and strtotime($v3_SLA['date']) >= strtotime($SLA_between_date_3)) ){
					$t_soft_1 = $t_soft_1 + intval($v3_SLA['time']);				
				}
				elseif ( $v3_SLA['oos_object'] == "soft" and (strtotime($v3_SLA['date']) >= strtotime($SLA_between_date_2) and strtotime($v3_SLA['date']) < strtotime($SLA_between_date_1)-1) ){
					$t_soft_2 = $t_soft_2 + intval($v3_SLA['time']);				
				}
				elseif ( $v3_SLA['oos_object'] == "soft" and (strtotime($v3_SLA['date']) >= strtotime($SLA_between_date_1) and strtotime($v3_SLA['date']) < strtotime($SLA_stop_date)-1) ){
					$t_soft_3 = $t_soft_3 + intval($v3_SLA['time']);
				}
				elseif ( $v3_SLA['oos_object'] == "net" and (strtotime($v3_SLA['date']) < strtotime($SLA_between_date_2) and strtotime($v3_SLA['date']) >= strtotime($SLA_between_date_3)) ){
					$t_net_1 = $t_net_1 + intval($v3_SLA['time']);				
				}
				elseif ( $v3_SLA['oos_object'] == "net" and (strtotime($v3_SLA['date']) >= strtotime($SLA_between_date_2) and strtotime($v3_SLA['date']) < strtotime($SLA_between_date_1)-1) ){
					$t_net_2 = $t_net_2 + intval($v3_SLA['time']);				
				}
				elseif ( $v3_SLA['oos_object'] == "net" and (strtotime($v3_SLA['date']) >= strtotime($SLA_between_date_1) and strtotime($v3_SLA['date']) < strtotime($SLA_stop_date)-1) ){
					$t_net_3 = $t_net_3 + intval($v3_SLA['time']);
				}
			}
			
			//Calculate common t_soft and t_net
			foreach($table_list_arr_body_m3 as $v3_SLA){
				if ( $v3_SLA['oos_object'] == "soft" and (strtotime($v3_SLA['date']) < strtotime($SLA_stop_date) and strtotime($v3_SLA['date']) >= strtotime($SLA_start_date)) ){
					$t_soft = $t_soft + intval($v3_SLA['time']);				
				}
				elseif ( $v3_SLA['oos_object'] == "net" and (strtotime($v3_SLA['date']) < strtotime($SLA_stop_date) and strtotime($v3_SLA['date']) >= strtotime($SLA_start_date))  ){
					$t_net = $t_net + intval($v3_SLA['time']);				
				}
				
			}
				
			?><br><?
			$t_common_1 = $t_soft_1 + $t_net_1;
			$t_common_2= $t_soft_2 + $t_net_2;
			$t_common_3 = $t_soft_3 + $t_net_3;
			$t_common = $t_soft+ $t_net;
			//echo $t_common;
			//echo $t_common_1;
			//echo $t_common_2;
			//echo $t_common_3;
			
			$date_m3_1 = new DateTime($SLA_start_date); 
			$date_m3_2 = new DateTime($SLA_between_date_1);
			$date_m3_3 = new DateTime($SLA_between_date_2);
			$date_m3_4 = new DateTime($SLA_between_date_3);
			$date_m3_5  = new DateTime($SLA_stop_date);
			
			$interval_m3_1 = $date_m3_4->diff($date_m3_3);
			$interval_m3_2 = $date_m3_3->diff($date_m3_2);
			$interval_m3_3 = $date_m3_2->diff($date_m3_5);
			$interval_m3_common = $date_m3_1->diff($date_m3_5);
			
			
			$during_m3_1 = $interval_m3_1->format('%a');
			$during_m3_2 = $interval_m3_2->format('%a');
			$during_m3_3 = $interval_m3_3->format('%a');
			$during_m3_common = $interval_m3_common->format('%a');
			//print_r($during_m3_1);
			//print_r($during_m3_2);
			//print_r($during_m3_3);
			//print_r($during_m3_common);
	
			$K_commmon_1= K_got($during_m3_1,$t_common_1);
			$K_commmon_2= K_got($during_m3_2,$t_common_2);
			$K_commmon_3= K_got($during_m3_3,$t_common_3);
			$K_commmon = K_got($during_m3_common,$t_common);
			
			$K_SOFT_1= K_got($during_m3_1,$t_soft_1);
			$K_SOFT_2= K_got($during_m3_2,$t_soft_2);
			$K_SOFT_3= K_got($during_m3_3,$t_soft_3);
			$K_SOFT = K_got($during_m3_common,$t_soft);
			
			$K_NET_1= K_got($during_m3_1,$t_net_1);
			$K_NET_2= K_got($during_m3_2,$t_net_2);
			$K_NET_3= K_got($during_m3_3,$t_net_3);
			$K_NET = K_got($during_m3_common,$t_net);
			
		
		?><div id = "SLA"><table id = "SLA" border="1">
    <tr>
        <td></td>
        <td colspan="3"><?echo $months_array[$id_month_between_SLA_3['month']];?></td><td colspan="3"><?echo $months_array[$id_month_between_SLA_2['month']];?></td><td colspan="3"><?echo $months_array[$id_month_between_SLA_1['month']];?></td><td colspan="3">Итог</td></tr>
    <tr><td rowspan="2">Параметры</td><td colspan="2">Коэффициент готовности</td><td rowspan="2">Время простоя, сек.</td><td colspan="2">Коэффициент готовности</td><td rowspan="2">Время простоя, сек.</td><td colspan="2">Коэффициент готовности</td><td rowspan="2">Время простоя, сек.</td><td colspan="2">Коэффициент готовности</td><td rowspan="2">Время простоя, сек.</td></tr>
    <tr><td>Факт.</td><td>Норм.</td><td>Факт.</td><td>Норм.</td><td>Факт.</td><td>Норм.</td><td>Факт.</td><td>Норм.</td></tr>
    <tr><td>Доступность услуги (в целом)</td>
		<td><font color=<?if($K_norm_SLA > $K_commmon_1){?>red<?} ?>><? echo number_format($K_commmon_1,3);?></font></td>
		<td><? echo number_format($K_norm_SLA,3);?></td>
		<td><?echo $t_common_1;?></td>
		<td><font color=<?if($K_norm_SLA > $K_commmon_2){?>red<?} ?>><? echo number_format($K_commmon_2,3);?></font></td>
        <td><? echo number_format($K_norm_SLA,3);?></td>
        <td><?echo $t_common_2;?></td>
        <td><font color=<?if($K_norm_SLA > $K_commmon_3){?>red<?} ?>><? echo number_format($K_commmon_3,3);?></font></td>
        <td><? echo number_format($K_norm_SLA,3);?></td>
        <td><?echo $t_common_3;?></td>
        <td><font color=<?if($K_norm_SLA > $K_commmon){?>red<?} ?>><? echo number_format($K_commmon,3);?></font></td>
        <td><? echo number_format($K_norm_SLA,3);?></td>
        <td><?echo $t_common;?></td>
    </tr>
    <tr>
        <td>Доступность ПО</td>
        <td><font color=<?if($K_norm_SLA > $K_SOFT_1){?>red<?} ?>><? echo number_format($K_SOFT_1,3);?></font></td>
        <td><? echo number_format($K_norm_SLA,3);?></td>
        <td><?echo $t_soft_1;?></td>
        <td><font color=<?if($K_norm_SLA > $K_SOFT_2){?>red<?} ?>><? echo number_format($K_SOFT_2,3);?></font></td>
        <td><? echo number_format($K_norm_SLA,3);?></td>
        <td><?echo $t_soft_2;?></td>
        <td><font color=<?if($K_norm_SLA > $K_SOFT_3){?>red<?} ?>><? echo number_format($K_SOFT_3,3);?></font></td>
        <td><? echo number_format($K_norm_SLA,3);?></td>
        <td><?echo $t_soft_3;?></td>
        <td><font color=<?if($K_norm_SLA > $K_SOFT){?>red<?} ?>><? echo number_format($K_SOFT,3);?></font></td>
        <td><? echo number_format($K_norm_SLA,3);?></td>
        <td><?echo $t_soft;?></td>
    </tr>
    <tr>
        <td>Доступность сети</td>
        <td><font color=<?if($K_norm_SLA > $K_NET_1){?>red<?} ?>><? echo number_format($K_NET_1,3);?></font></td>
        <td><? echo number_format($K_norm_SLA,3);?></td>
        <td><?echo $t_net_1;?></td>
        <td><font color=<?if($K_norm_SLA > $K_NET_2){?>red<?} ?>><? echo number_format($K_NET_2,3);?></font></td>
        <td><? echo number_format($K_norm_SLA,3);?></td>
        <td><?echo $t_net_2;?></td>
        <td><font color=<?if($K_norm_SLA > $K_NET_3){?>red<?} ?>><? echo number_format($K_NET_3,3);?></font></td>
        <td><? echo number_format($K_norm_SLA,3);?></td>
        <td><?echo $t_net_3;?></td>
        <td><font color=<?if($K_norm_SLA > $K_NET){?>red<?} ?>><? echo number_format($K_NET,3);?></font></td>
        <td><? echo number_format($K_norm_SLA,3);?></td>
        <td><?echo $t_net;?></td>
    </tr>
</table></div>

<?
		}?>
	</td></tr>
	<tr>
		<td>
	Нормативная информация<br>
		</td>
		<td><b>:</b></td>
		<td>
			<a target="_blank" href="/project/tscloud/files/rusagro_contract.pdf"><img style="padding-right:8px" class="imgmiddle" src="/project/tscloud/files/pdf_hover.png">Текст договора</a>
		</td>
	</tr>
	<?
	}?>