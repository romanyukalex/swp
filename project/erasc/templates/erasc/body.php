<? /******************************************************************
  * Snippet Name : body           				 					 * 
  * Scripted By  : RomanyukAlex		           						 * 
  * Website      : http://popwebstudio.ru	   						 * 
  * Email        : admin@popwebstudio.ru     					     * 
  * License      : License on popwebstudio.ru	from autor		 	 *
  * Purpose 	 : Тело страницы обрамленное тегами <body></body>	 *
  * Insert		 : include_once('/templates/$currenttemplate/body.php');						 *
  *******************************************************************/ 

###################################################
# Начало шаблона
###################################################

#####################################
# Required 1						#
#####################################
$log->LogInfo('Got '.(__FILE__));
if(!$block and $nitka=="1"){ // Проверили, не запретил ли какой-нибудь скрипт показ тела страницы и что не запущен только body
	if (($showsiteforguest=="Не разрешать" and $userrole!=="guest") or $showsiteforguest=="Разрешать"){
#####################################
# // Required 1						#
#####################################?>
<? if($enablegatagcount!=="Не включать") insert_module("counter-ga_tagmanager");
#####################################
# Body user part					#
#####################################
?>


  <div class="clearfix" id="page"><!-- column -->
   <div class="position_content" id="page_position_content">
    <div class="clearfix colelem" id="pu87"><!-- group -->
     <div class="browser_width grpelem" id="u87-bw">
      <div id="u87"><!-- group -->
       <div class="clearfix" id="u87_align_to_page">
        <a class="nonblock nontext MuseLinkActive clip_frame grpelem" id="u99" href="http://aoglonass.ru/index.html"><!-- image --><img class="block" id="u99_img" src="/project/<?=$projectname?>/templates/erasc/files/logo0000.png" alt="" width="368" height="81"></a>
        <div class="pointer_cursor rounded-corners clearfix grpelem" id="u173"><!-- group -->
         <a class="block" href="http://aoglonass.ru/about.html"></a>
         <a class="nonblock nontext clearfix grpelem" id="u116-4" href="http://aoglonass.ru/about.html"><!-- content --><p>О компании</p></a>
        </div>
        <div class="pointer_cursor rounded-corners clearfix grpelem" id="u177"><!-- group -->
         <a class="block" href="http://aoglonass.ru/documents.html"></a>
         <a class="nonblock nontext clearfix grpelem" id="u122-4" href="http://aoglonass.ru/documents.html"><!-- content --><p>Документы</p></a>
        </div>
       </div>
      </div>
     </div>
     <div class="browser_width grpelem" id="u124-bw">
      <div id="u124"><!-- group -->
       <div class="clearfix" id="u124_align_to_page">
        <div class="clip_frame grpelem" id="u272"><!-- image -->
         <img class="block" id="u272_img" src="/project/<?=$projectname?>/templates/erasc/files/map00000.png" alt="" width="1084" height="578">
        </div>
        <div class="clearfix grpelem" id="u500-4"><!-- content -->
         <p>АО «ГЛОНАСС» - оператор государственной автоматизированной информационной системы «ЭРА-ГЛОНАСС»</p>
		 <?
		$months_array = array(1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь');
		
		function K_got($dur,$t)
		{
			return ($dur*24*60*60 - $t)*100/($dur*24*60*60);;
		}

		$SLA_start_date = "2016-01-01";
		$SLA_stop_date = '2016-06-30';
		
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
			$K_commmon_3= K_got($during_m3_2,$t_common_3);
			$K_commmon = K_got($during_m3_common,$t_common);
			
			$K_SOFT_1= K_got($during_m3_1,$t_soft_1);
			$K_SOFT_2= K_got($during_m3_2,$t_soft_2);
			$K_SOFT_3= K_got($during_m3_3,$t_soft_3);
			$K_SOFT = K_got($during_m3_common,$t_soft);
			
			$K_NET_1= K_got($during_m3_1,$t_net_1);
			$K_NET_2= K_got($during_m3_2,$t_net_2);
			$K_NET_3= K_got($during_m3_3,$t_net_3);
			$K_NET = K_got($during_m3_common,$t_net);
			
		
		?><table border="1">
    <tr>
        <td></td>
        <td colspan="3"><?echo $months_array[$id_month_between_SLA_3['month']];?></td><td colspan="3"><?echo $months_array[$id_month_between_SLA_2['month']];?></td><td colspan="3"><?echo $months_array[$id_month_between_SLA_1['month']];?></td><td colspan="3">Итог</td></tr>
    <tr><td rowspan="2">Параметры</td><td colspan="2">Коэффициент готовности</td><td rowspan="2">Время простоя, мин.</td><td colspan="2">Коэффициент готовности</td><td rowspan="2">Время простоя, мин.</td><td colspan="2">Коэффициент готовности</td><td rowspan="2">Время простоя, мин.</td><td colspan="2">Коэффициент готовности</td><td rowspan="2">Время простоя, мин.</td></tr>
    <tr><td>Факт.</td><td>Норм.</td><td>Факт.</td><td>Норм.</td><td>Факт.</td><td>Норм.</td><td>Факт.</td><td>Норм.</td></tr>
    <tr><td>Доступность услуги (в целом)</td>
		<td><p><font color=<?if($K_norm_SLA > $K_commmon_1){?>red<?} ?>><? echo number_format($K_commmon_1,5);?></font></p></td>
		<td><? echo number_format($K_norm_SLA,5);?></td>
		<td><?echo $t_common_1;?></td>
		<td><p><font color=<?if($K_norm_SLA > $K_commmon_2){?>red<?} ?>><? echo number_format($K_commmon_2,5);?></font></p></td>
        <td><? echo number_format($K_norm_SLA,5);?></td>
        <td><?echo $t_common_2;?></td>
        <td><p><font color=<?if($K_norm_SLA > $K_commmon_3){?>red<?} ?>><? echo number_format($K_commmon_3,5);?></font></p></td>
        <td><? echo number_format($K_norm_SLA,5);?></td>
        <td><?echo $t_common_3;?></td>
        <td><p><font color=<?if($K_norm_SLA > $K_commmon){?>red<?} ?>><? echo number_format($K_commmon,5);?></font></p></td>
        <td><? echo number_format($K_norm_SLA,5);?></td>
        <td><?echo $t_common;?></td>
    </tr>
    <tr>
        <td>Доступность ПО</td>
        <td><p><font color=<?if($K_norm_SLA > $K_SOFT_1){?>red<?} ?>><? echo number_format($K_SOFT_1,5);?></font></p></td>
        <td><? echo number_format($K_norm_SLA,5);?></td>
        <td><?echo $t_soft_1;?></td>
        <td><p><font color=<?if($K_norm_SLA > $K_SOFT_2){?>red<?} ?>><? echo number_format($K_SOFT_2,5);?></font></p></td>
        <td><? echo number_format($K_norm_SLA,5);?></td>
        <td><?echo $t_soft_2;?></td>
        <td><p><font color=<?if($K_norm_SLA > $K_SOFT_3){?>red<?} ?>><? echo number_format($K_SOFT_3,5);?></font></p></td>
        <td><? echo number_format($K_norm_SLA,5);?></td>
        <td><?echo $t_soft_3;?></td>
        <td><p><font color=<?if($K_norm_SLA > $K_SOFT){?>red<?} ?>><? echo number_format($K_SOFT,5);?></font></p></td>
        <td><? echo number_format($K_norm_SLA,5);?></td>
        <td><?echo $t_soft;?></td>
    </tr>
    <tr>
        <td>Доступность сети</td>
        <td><p><font color=<?if($K_norm_SLA > $K_NET_1){?>red<?} ?>><? echo number_format($K_NET_1,5);?></font></p></td>
        <td><? echo number_format($K_norm_SLA,5);?></td>
        <td><?echo $t_net_1;?></td>
        <td><p><font color=<?if($K_norm_SLA > $K_NET_2){?>red<?} ?>><? echo number_format($K_NET_2,5);?></font></p></td>
        <td><? echo number_format($K_norm_SLA,5);?></td>
        <td><?echo $t_net_2;?></td>
        <td><p><font color=<?if($K_norm_SLA > $K_NET_3){?>red<?} ?>><? echo number_format($K_NET_3,5);?></font></p></td>
        <td><? echo number_format($K_norm_SLA,5);?></td>
        <td><?echo $t_net_3;?></td>
        <td><p><font color=<?if($K_norm_SLA > $K_NET){?>red<?} ?>><? echo number_format($K_NET,5);?></font></p></td>
        <td><? echo number_format($K_norm_SLA,5);?></td>
        <td><?echo $t_net;?></td>
    </tr>
</table>

<?
		
		
		
		}

			//$ip может принемать значения как ip так и ip:port
function db_connection($ip, $username, $password, $db)
{
    $link = mysql_connect($ip, $username, $password);
    if (!$link) {
        //Неудачная попытка подключения
        echo mysql_error();
        return False;
    }
    $selected_db = mysql_select_db($db, $link);
    if (!$selected_db) {
        echo mysql_error();
        mysql_close($link);
        return False;
    }
    return $link;
}

//Функция select к выбранному подключению
function query_to_DB($query, $link)
{
    $result = mysql_query($query, $link);
    //Проверяем результат, если пришел False, значит ошибка.
    if (!$result) {
        echo mysql_error();
        return False;
    }
    //Вернет тип resource в случае результата состоящего из нескольких рядов
    //либо True для односложного результата
    return $result;
}

//Функция подсчета секунд в диапазоне дат
//Формат строки в переменных YYYY-MM-DD hh:mm:ss, например "2008-12-13 10:42:00"
//Возвращает integer секунд
function time_diff_in_minutes($date_from, $date_to)
{
    $tmp_result = intval(abs(strtotime($date_from) - strtotime($date_to)));
    return $tmp_result;
}

//Функция сложения времяни из массива
//На входе вложенный массив сформированный из запроса в БД и перечень node_id по которым делается сложение
//На выходе целое значение минут простоя
function sum_downtime_by_ids($main_array, $id_array)
{
    if (count($main_array) == 0) {
        return 0;
    }
    $date = explode(" ", $main_array[0]["event_date"])[0];
    $k = 0;
    $tmp_array = array("current_status" => "up", "down_time" => 0, "current_time" => $date." 00:00:00");
    foreach($main_array as $key => $value) {
    	//echo "key ".$key;
    	//echo"value ";print_r($value)?><!--br--><?;
        if (in_array($main_array[$key]["node_id"], $id_array)) {
            $k++;
            if ($tmp_array["current_status"] == "up") {
                if ($main_array[$key]["event"] == "alive") {
                    $tmp_array["down_time"] = $tmp_array["down_time"] +
                    time_diff_in_minutes($tmp_array["current_time"],
                                         $main_array[$key]["event_date"]);
                    $tmp_array["current_time"] = $main_array[$key]["event_date"];
                } else {
                    $tmp_array["current_status"] = "down";
                    $tmp_array["current_time"] = $main_array[$key]["event_date"];
                }
            } else {
                if ($main_array[$key]["event"] == "alive") {
                    $tmp_array["down_time"] = $tmp_array["down_time"] +
                    time_diff_in_minutes($tmp_array["current_time"],
                                         $main_array[$key]["event_date"]);
                    $tmp_array["current_time"] = $main_array[$key]["event_date"];
                    $tmp_array["current_status"] = "up";
                }
            }
        }
    }
    if ($k === 0) {
        return 0;
    }
    //print_r($tmp_array);
    if ($tmp_array["current_status"] == "down") {
        return $tmp_array["down_time"] + time_diff_in_minutes($tmp_array["current_time"], $date." 23:59:59");
    } else {
        return $tmp_array["down_time"];
    }
}
//SELECT * FROM `tscloud-monitor-events` WHERE `event_date` BETWEEN '2015-11-15 00:00:00' AND '2015-11-15 23:59:59';
//Тесты, потом удалю
$date = '2016-06-24';
$link = db_connection("localhost","aromanuq_erasc", "2mS0Xa8&8C0uW^3E", "aromanuq_erasc");
$result = query_to_DB("SELECT * FROM `tscloud-monitor-events` WHERE `event_date` BETWEEN '$date 00:00:00' AND '$date 23:59:59';", $link);
$array_result = array();
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    array_push($array_result, $row);
}
//print_r($array_result);
$node_id = array('2');
echo "\n";
?><br><?
//echo (sum_downtime_by_ids($array_result, $node_id));

//for ($i=0;;$i++);

$date = '2016-01-01';
/*
while (date("Y-m-d",time()) >= $date) {
	echo "* ";


}

*/
//mysql_query("INSERT INTO  `tscloud-monitor-outofservice` (`oos_object` ,`date` ,`time`) VALUES ('soft',  '$date',  '".sum_downtime_by_ids($array_result, $node_id)."');");

function calcdowntime($dateStart,$dateStop,$nodeid_array) {
	$link = db_connection("localhost","aromanuq_erasc", "2mS0Xa8&8C0uW^3E", "aromanuq_erasc");
	$result = query_to_DB("SELECT * FROM `tscloud-monitor-events` WHERE `event_date` BETWEEN '$dateStart. 00:00:00' AND '$dateStop. 23:59:59';", $link);
	$array_result = array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    	array_push($array_result, $row);
    //print_r($array_result);
 
}
	}
$dateStart = '2016-01-01';
$dateStop = '2016-07-02';

print_r(calcdowntime($dateStart,$dateStop,$node_id));



//
		

				
		 ?>
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
        </div>
        <div class="clearfix grpelem" id="u501-6"><!-- content -->
         <p><br><br><br><br><br><br><br><br><br><br><br><br>Система «ЭРА-ГЛОНАСС» работает во всех регионах</p>
         <p>Российской Федерации</p>
        </div>
       </div>
      </div>
     </div>
     <div class="browser_width grpelem" id="u125-bw">
      <div id="u125"><!-- simple frame --></div>
     </div>
     <div class="browser_width grpelem" id="u400-bw">
      <div id="u400"><!-- simple frame --></div>
     </div>
     <div class="browser_width grpelem" id="u126-bw">
      <div id="u126"><!-- simple frame --></div>
     </div>
     <div class="clearfix grpelem" id="u128-4"><!-- content -->
      <p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>АО «ГЛОНАСС»</p>
     </div>
     <div class="clearfix grpelem" id="u129-6"><!-- content -->
      <p>Акционерное общество «ГЛОНАСС» (создано со 100% государственным участием) — оператор ГАИС «ЭРА-ГЛОНАСС»</p>
      <p>с 1 января 2016 года.</p>
     </div>
     <div class="clearfix grpelem" id="u137-10"><!-- content -->
      <p>Среди направлений деятельности общества: использование и развитие технологической инфраструктуры «ЭРА-ГЛОНАСС» в интересах операторов ведомственных, региональных и корпоративных систем, автопроизводителей</p>
      <p>и страховых компаний, реализация навигационно-информационных проектов</p>
      <p>в России и за рубежом, предоставление услуг навигации повышенной</p>
      <p>точности и надежности.</p>
     </div>
     <div class="clearfix grpelem" id="u402-4"><!-- content -->
      <p>УВО Минтранса подключило сервис «ЭРА-ГЛОНАСС Мониторинг»</p>
     </div>
     <div class="clearfix grpelem" id="u788-4"><!-- content -->
      <p>«ЭРА-ГЛОНАСС» зарегистрировала экстренный вызов от свидетеля ДТП в Самарской области</p>
     </div>
     <div class="clearfix grpelem" id="u743-4"><!-- content -->
      <p>Новый Jaguar XF оборудуют системой «ЭРА-ГЛОНАСС»</p>
     </div>
     <div class="clearfix grpelem" id="u779-4"><!-- content -->
      <p>Ford Sollers начала производство Transit с устройством «ЭРА-ГЛОНАСС»</p>
     </div>
     <div class="clearfix grpelem" id="u403-8"><!-- content -->
      <p id="u403-2">ФГУП "УВО Минтранса России" (Федеральное государственное унитарное предприятие "Управление ведомственной охраны Министерства транспорта Российской Федерации") в рамках сотрудничества с АО «ГЛОНАСС» подключило к услуге «ЭРА-ГЛОНАСС Мониторинг» все девять филиалов предприятия. Оснащение техники происходило по всей территории Российской Федерации от Калининграда до Владивостока. Данные транспортные средства ведут патрулирование на различных объектах, которые охраняет УВО Минтранса РФ, а также выполняют хозяйственные нужны предприятия.</p>
      <p id="u403-4">В феврале 2016 года в УВО Минтранса был введен порядок «Организация работ с применением системы мониторинга транспортных средств». Специалисты АО «ГЛОНАСС» проводят обучение сотрудников предприятия и помогают наладить работу с применением сервиса «ЭРА-ГЛОНАСС Мониторинг».</p>
      <p id="u403-6">Сервис «ЭРА-ГЛОНАСС Мониторинг» позволил УВО Минтранса России контролировать свои транспортные средства, отслеживать места их базирования, геозоны, маршруты и получать прочую информацию, доступную при использовании технологии мониторинга.</p>
     </div>
     <div class="clearfix grpelem" id="u785-6"><!-- content -->
      <p id="u785-2">18.02.2016 в 16.21 мск, государственная автоматизированная информационная система «ЭРА-ГЛОНАСС» зарегистрировала экстренный вызов из Самарской области. Обратившийся абонент сообщил оператору ГАИС «ЭРА-ГЛОНАСС», что стал свидетелем ДТП. Вызов был передан в территориальный орган МВД России по Самарской области.</p>
      <p id="u785-4">Важно отметить, что нажал кнопку экстренного вызова водитель, который 14.02.2016 сам являлся участником ДТП и, воспользовавшись системой «ЭРА-ГЛОНАСС», получил помощь.</p>
     </div>
     <div class="clearfix grpelem" id="u746-4"><!-- content -->
      <p id="u746-2">Компания Jaguar Land Rover провела специальные краш-тесты нового поколения Jaguar XF для российского рынка. Целью таких испытаний стояла проверка корректности работы ГАИС «ЭРА-ГЛОНАСС», которой по у молчанию будут оснащены все бизнес-седаны XF на российском рынке. Краш-тесты прошли успешно. Jaguar XF станет первой моделью компании в России с установленной системой «ЭРА-ГЛОНАСС».</p>
     </div>
     <div class="clearfix grpelem" id="u776-6"><!-- content -->
      <p id="u776-2">Компания Ford Sollers завершила сертификацию автомобилей Ford Transit, оснащенных устройством «ЭРА-ГЛОНАСС», и начала серийное производство Ford Transit в модификациях Bus категории M2 (пассажирские автобусы) и Van категории N2 (цельнометаллический фургон полной массой свыше 3,5 т), оснащенных устройством вызова экстренных оперативных служб «ЭРА-ГЛОНАСС».</p>
      <p id="u776-4">В рамках проекта по оборудованию Ford Transit устройством экстренного реагирования в автомобили устанавливаются следующие компоненты: микрофон и кнопка «Экстренный вызов» с индикатором в потолочной консоли, громкоговорители в передних дверях, телекоммуникационный модуль под перчаточным ящиком, антенна связи и ГНСС.</p>
     </div>
     <div class="clearfix grpelem" id="u404-4"><!-- content -->
      <p>2 марта 2016</p>
     </div>
     <div class="clearfix grpelem" id="u791-4"><!-- content -->
      <p>18 февраля 2016</p>
     </div>
     <div class="clearfix grpelem" id="u740-4"><!-- content -->
      <p>10 февраля 2016</p>
     </div>
     <div class="clearfix grpelem" id="u782-4"><!-- content -->
      <p>16 февраля 2016</p>
     </div>
     <div class="clearfix grpelem" id="u401-4"><!-- content -->
      <p id="u401-2"><span class="H2" id="u401">События</span></p>
     </div>
     <div class="clip_frame grpelem" id="u181"><!-- image -->
      <img class="block" id="u181_img" src="/project/<?=$projectname?>/templates/erasc/files/flag0000.png" alt="" width="339" height="346">
     </div>
    </div>
    <div class="clearfix colelem" id="u179-4"><!-- content -->
     <p id="u179-2"><span class="H2" id="u179">Наши партнеры</span></p>
    </div>
    <div class="clearfix colelem" id="pu804"><!-- group -->
     <div class="clip_frame grpelem" id="u804"><!-- image -->
      <img class="block" id="u804_img" src="/project/<?=$projectname?>/templates/erasc/files/rosset00.png" alt="" width="214" height="100">
     </div>
     <div class="clip_frame grpelem" id="u455"><!-- image -->
      <img class="block" id="u455_img" src="/project/<?=$projectname?>/templates/erasc/files/gtlk0000.png" alt="" width="214" height="100">
     </div>
     <div class="clip_frame grpelem" id="u794"><!-- image -->
      <img class="block" id="u794_img" src="/project/<?=$projectname?>/templates/erasc/files/td201800.jpg" alt="" width="214" height="100">
     </div>
     <div class="clip_frame grpelem" id="u410"><!-- image -->
      <img class="block" id="u410_img" src="/project/<?=$projectname?>/templates/erasc/files/rsa00000.png" alt="" width="214" height="100">
     </div>
    </div>
    <div class="clearfix colelem" id="pu258-4"><!-- group -->
     <div class="clearfix grpelem" id="u258-4"><!-- content -->
      <p>ПАО «Россети»</p>
     </div>
     <div class="clearfix grpelem" id="u261-4"><!-- content -->
      <p>ПАО «ГТЛК»</p>
     </div>
     <div class="clearfix grpelem" id="u260-4"><!-- content -->
      <p>АНО «Транспортная дирекция 2018»</p>
     </div>
     <div class="clearfix grpelem" id="u263-4"><!-- content -->
      <p>РСА (Российский союз автостраховщиков)</p>
     </div>
    </div>
    <div class="clearfix colelem" id="pu422"><!-- group -->
     <div class="clip_frame grpelem" id="u422"><!-- image -->
      <img class="block" id="u422_img" src="/project/<?=$projectname?>/templates/erasc/files/ibg00000.png" alt="" width="214" height="100">
     </div>
     <div class="clip_frame grpelem" id="u428"><!-- image -->
      <img class="block" id="u428_img" src="/project/<?=$projectname?>/templates/erasc/files/satelit0.png" alt="" width="214" height="100">
     </div>
     <div class="clip_frame grpelem" id="u416"><!-- image -->
      <img class="block" id="u416_img" src="/project/<?=$projectname?>/templates/erasc/files/t1000000.png" alt="" width="214" height="100">
     </div>
    </div>
    <div class="clearfix colelem" id="pu262-4"><!-- group -->
     <div class="clearfix grpelem" id="u262-4"><!-- content -->
      <p>IBG (Страховая бизнес группа)</p>
     </div>
     <div class="clearfix grpelem" id="u264-4"><!-- content -->
      <p>АО «РНИЦ по Тамбовской области»</p>
     </div>
     <div class="clearfix grpelem" id="u259-4"><!-- content -->
      <p>АО «Цезарь Сателлит»</p>
     </div>
     <div class="clearfix grpelem" id="u265-4"><!-- content -->
      <p>Т1</p>
     </div>
    </div>
    <div class="browser_width colelem" id="u697-bw">
     <div id="u697"><!-- group -->
      <div class="clearfix" id="u697_align_to_page">
       <div class="clearfix grpelem" id="pu700-4"><!-- column -->
        <div class="clearfix colelem" id="u700-4"><!-- content -->
         <p>Контакты:</p>
        </div>
        <div class="clearfix colelem" id="u702-7"><!-- content -->
         <p id="u702-2">127055, Россия, Москва, ул. Новолесная, 3</p>
         <p id="u702-4">тел/факс: +7 (499) 973-57-79</p>
         <p id="u702-5">&nbsp;</p>
        </div>
       </div>
       <div class="clearfix grpelem" id="pu701-4"><!-- column -->
        <div class="clearfix colelem" id="u701-4"><!-- content -->
         <p>Пресс-центр:</p>
        </div>
        <div class="clearfix colelem" id="u703-4"><!-- content -->
         <p>press@aoglonass.ru</p>
        </div>
       </div>
       <a class="nonblock nontext clip_frame grpelem" id="u704" href="https://www.facebook.com/aoglonass/" target="_blank"><!-- image --><img class="block" id="u704_img" src="/project/<?=$projectname?>/templates/erasc/files/facebook.png" alt="" title="https://www.facebook.com/aoglonass/" width="58" height="58"></a>
      </div>
     </div>
    </div>
    <div class="browser_width colelem" id="u696-bw">
     <div id="u696"><!-- group -->
      <div class="clearfix" id="u696_align_to_page">
       <div class="clearfix grpelem" id="u698-4"><!-- content -->
        <p>© 2016 Акционерное общество «ГЛОНАСС»</p>
       </div>
       <div class="clearfix grpelem" id="u699-4"><!-- content -->
        <p>Сайт находится в стадии разработки</p>
       </div>
      </div>
     </div>
    </div>
    <div class="verticalspacer"></div>
   </div>
  </div>
  <!-- JS includes -->
  <script type="text/javascript">
   if (document.location.protocol != 'https:') document.write('\x3Cscript src="http://musecdn2.businesscatalyst.com/scripts/4.0/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script type="text/javascript">
   window.jQuery || document.write('\x3Cscript src="scripts/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script src="/project/<?=$projectname?>/templates/erasc/files/museutil.js" type="text/javascript"></script>
  <script src="/project/<?=$projectname?>/templates/erasc/files/whatinpu.js" type="text/javascript"></script>
  <script src="/project/<?=$projectname?>/templates/erasc/files/jquery00.js" type="text/javascript"></script>
  <!-- Other scripts -->
  <script type="text/javascript">
   $(document).ready(function() { try {
(function(){var a={},b=function(a){if(a.match(/^rgb/))return a=a.replace(/\s+/g,"").match(/([\d\,]+)/gi)[0].split(","),(parseInt(a[0])<<16)+(parseInt(a[1])<<8)+parseInt(a[2]);if(a.match(/^\#/))return parseInt(a.substr(1),16);return 0};(function(){$('link[type="text/css"]').each(function(){var b=($(this).attr("href")||"").match(/\/?css\/([\w\-]+\.css)\?(\d+)/);b&&b[1]&&b[2]&&(a[b[1]]=b[2])})})();(function(){$("body").append('<div class="version" style="display:none; width:1px; height:1px;"></div>');
for(var c=$(".version"),d=0;d<Muse.assets.required.length;){var f=Muse.assets.required[d],g=f.match(/([\w\-\.]+)\.(\w+)$/),k=g&&g[1]?g[1]:null,g=g&&g[2]?g[2]:null;switch(g.toLowerCase()){case "css":k=k.replace(/\W/gi,"_").replace(/^([^a-z])/gi,"_$1");c.addClass(k);var g=b(c.css("color")),h=b(c.css("background-color"));g!=0||h!=0?(Muse.assets.required.splice(d,1),"undefined"!=typeof a[f]&&(g!=a[f]>>>24||h!=(a[f]&16777215))&&Muse.assets.outOfDate.push(f)):d++;c.removeClass(k);break;case "js":k.match(/^jquery-[\d\.]+/gi)&&
typeof $!="undefined"?Muse.assets.required.splice(d,1):d++;break;default:throw Error("Unsupported file type: "+g);}}c.remove();if(Muse.assets.outOfDate.length||Muse.assets.required.length)c="Some files on the server may be missing or incorrect. Clear browser cache and try again. If the problem persists please contact website author.",(d=location&&location.search&&location.search.match&&location.search.match(/muse_debug/gi))&&Muse.assets.outOfDate.length&&(c+="\nOut of date: "+Muse.assets.outOfDate.join(",")),d&&Muse.assets.required.length&&(c+="\nMissing: "+Muse.assets.required.join(",")),alert(c)})()})();
/* body */
Muse.Utils.transformMarkupToFixBrowserProblemsPreInit();/* body */
Muse.Utils.prepHyperlinks(true);/* body */
Muse.Utils.resizeHeight('.browser_width');/* resize height */
Muse.Utils.requestAnimationFrame(function() { $('body').addClass('initialized'); });/* mark body as initialized */
Muse.Utils.fullPage('#page');/* 100% height page */
Muse.Utils.showWidgetsWhenReady();/* body */
Muse.Utils.transformMarkupToFixBrowserProblems();/* body */
} catch(e) { if (e && 'function' == typeof e.notify) e.notify(); else Muse.Assert.fail('Error calling selector function:' + e); }});
</script>


<?
#####################################
# // Body							#
#####################################

#####################################
# Required 2						#
#####################################
	}
	else{
		insert_module("loginform_simple");
	}
} else {echo "Запрещен вход на сайт";
}
#####################################
# // Required 2						#
#####################################?>