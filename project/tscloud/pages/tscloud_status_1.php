<div>
<link type="text/css" rel="stylesheet" href="/project/tscloud/files/slide.css" />
<script type="text/javascript" src="/project/tscloud/files/jquery.scrollTo.js"></script>
<script type="text/javascript" src="/project/tscloud/files/jquery.serialScroll.js"></script>

<script language="javascript">

$(document).ready(function(){

$(".mini a").hover(function(){

$(this).next(".mini .text1").css({'display':'block'})
.end();
return false;


}, 
function(){

$(this).next(".mini .text1").slideUp(100);
return false;

});

$(".mini .text img").click(function(){

$(this).parent(".mini .text1").hide(300);
return false;


});



});

</script>
<script type="text/javascript">	
		jQuery.easing.easeOutQuart = function (x, t, b, c, d) {
			return -c * ((t=t/d-1)*t*t*t - 1) + b;
		};
		
		jQuery(function( $ ){
			$('#screen').serialScroll({
				target:'#sections',
				items:'li', // Selector to the items ( relative to the matched elements, '#sections' in this case )
				prev:'img.prev',// Selector to the 'prev' button (absolute!, meaning it's relative to the document)
				next:'img.next',// Selector to the 'next' button (absolute too)
				axis:'xy',// The default is 'y' scroll on both ways
				navigation:'#navigation li a',
				duration:700,// Length of the animation (if you scroll 2 axes and use queue, then each axis take half this time)
				force:true, // Force a scroll to the element specified by 'start' (some browsers don't reset on refreshes)
			
				onBefore:function( e, elem, $pane, $items, pos ){
					e.preventDefault();
					if( this.blur )
						this.blur();
				},
				onAfter:function( elem ){
				}
			});			
		});
</script>

<style>
.mini a{
text-decoration:none;
color:#1D5F7F;
border-bottom:1px dashed;
z-index:4;
cursor: pointer;
}

#td {
text-align: center;
}
table, th, td {
   border: 1px solid black;
}


#krest{
float:right;
}

.text1{
//margin-top:20px;
}

#text23{
margin-top:20px;
}
.tabs-label a{
font-size: 12px;
color: #434343;
text-decoration:none;
font-size:bold;
}
</style>
<? if(!$_REQUEST['subpage']) $_REQUEST['subpage']="curstatus";?>
<div class="b-tabs b-tabs_styled js-tabs"> 
	<div class="tabs-label"> 
		<div id="notistoria" class="tab-label tab-label_<? if($_REQUEST['subpage']=="curstatus"){?>_active<? }else{?>_last<?}?>"><a href="/?page=tscloud_status_1&menu=tscloud&subpage=curstatus"><?if($language=="en"){?>Current state<?} elseif($language=="ru"){?>Текущее состояние<?}?></a></div>
		<div id="notistoria1" class="tab-label tab-label_<? if($_REQUEST['subpage']=="status_history"){?>_active<? }else{?>_last<?}?>"><a href="/?page=tscloud_status_1&menu=tscloud&subpage=status_history"><?if($language=="en"){?>Month history<?} elseif($language=="ru"){?>История за месяц<?}?></a></div>
		<div id="notistoria2" class="tab-label tab-label_<? if($_REQUEST['subpage']=="futureworks"){?>_active<? }else{?>_last<?}?> tab-label_next"><a href="/?page=tscloud_status_1&menu=tscloud&subpage=futureworks"><?if($language=="en"){?>Scheduled works<?} elseif($language=="ru"){?>Запланированные окна выполнения работ<?}?></a></div>
	</div>
	<div class="b-tabs2"></div>
	<div class="tabs-content b-text"> 
		<div class="tab-content_wrap"> 
			<div class="tab-content tab-content<? if($_REQUEST['subpage']=="curstatus"){?>_active<? }?>">
<?
					// Creating array that contains rows from MySQL(start and stop date and etc)
					$today_current_status = date("Y-m-d H:i:s");					
					//echo $today_current_status;
					$result_curstatus = mysql_query("SELECT /*`current_status_start_data`,`current_status_end_data`,*/`current_status_seg_id` FROM `tscloud-current_status` where (`current_status_start_data` <= '$today_current_status') and (`current_status_end_data` >= '$today_current_status') ;") or die(mysql_error());
					while($r_cur_st[]=mysql_fetch_array($result_curstatus));
					array_pop($r_cur_st);
					//print_r($r);
					// End of Creating array
					// Start devided array
					$sum_array=[];
					for($n=0;$n<count($r_cur_st);$n++){
						$devide_array=explode("*",$r_cur_st[$n][0]);
						//print_r($devide_array);
						for($m=0;$m<count($devide_array);$m++) {
							array_push($sum_array,$devide_array[$m]);
							//print_r($sum_array);
						}
					}
					$array_sum=array_unique($sum_array); // Delete nonunique items from array
					sort($array_sum); // sort items 
										
?>			
				<div class="b-other-projects b-text mb">
					<div class="wrap">             
						<div class="b-text_2col">
							<table cellspacing="0" id="tscloud_cur_status_table" class="fullWidth">
								<thead>
									<tr>
										<th colspan="2" style="width: 300px;" class="left gradient"><?if($language=="en"){?>Current status<?} elseif($language=="ru"){?>Текущий статус<?}?>:</th>
										<th id="td" style="padding-left: 8px"><?if($language=="en"){?>Detailed<?} elseif($language=="ru"){?>Детали<?}?></th>	  
									</tr>
								</thead>
								<tbody>         
									<tr>
									<?foreach($array_sum as $v) {
										if($v==1){$seg_a=1;}
										elseif($v==2){$seg_a=1;}
										elseif($v==3){$seg_b=1;}
										elseif($v==4){$seg_c=1;}
										elseif($v==5){$seg_d=1;}
										elseif($v==6){$seg_e=1;}
										elseif($v==7){$seg_f=1;}
									}
									//echo "a:".$seg_a; echo "b:".$seg_b; echo "c:".$seg_c; echo "d:".$seg_d; echo "e:".$seg_e;echo "f:".$seg_f;
									?>
										<td><img src=<?if($seg_a==1){?> "/project/tscloud/files/notification_warning.png"<?}else{?> "/project/tscloud/files/ok2.png"<?}?>>
										</td>
										<td><?if($language=="en"){?>Computing<?} elseif($language=="ru"){?>Вычислительные мощности<?}?></td>
										<td id="td"><?if ($seg_a==1) {if($language=="en"){?>Performance issues<?}elseif($language=="ru"){?>Деградация производительности<?}} 
													else{if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}}?></td>
									</tr>
									<tr>
										<td><img src=<?if($seg_b==1){?> "/project/tscloud/files/notification_warning.png"<?}else{?> "/project/tscloud/files/ok2.png"<?}?>></td>
										<td><?if($language=="en"){?>Network equipment<?} elseif($language=="ru"){?>Сетевое оборудование<?}?></td>
										<td id="td"><?if ($seg_b==1) {if($language=="en"){?>Performance issues<?}elseif($language=="ru"){?>Деградация производительности<?}} 
													else{if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}}?></td>
									</tr>
									<tr>
										<td><img src=<?if($seg_c==1){?> "/project/tscloud/files/notification_warning.png"<?}else{?> "/project/tscloud/files/ok2.png"<?}?>></td>
										<td><?if($language=="en"){?>SAN equipment<?} elseif($language=="ru"){?>Оборудование SAN-сети<?}?></td>
										<td id="td"><?if ($seg_c==1) {if($language=="en"){?>Performance issues<?}elseif($language=="ru"){?>Деградация производительности<?}} 
													else{if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}}?></td>
									</tr>
									<tr>
										<td><img src=<?if($seg_d==1){?> "/project/tscloud/files/notification_warning.png"<?}else{?> "/project/tscloud/files/ok2.png"<?}?>></td>
										<td><?if($language=="en"){?>Communication<?} elseif($language=="ru"){?>Каналы передачи данных<?}?></td>
										<td id="td"><?if ($seg_d==1) {if($language=="en"){?>Performance issues<?}elseif($language=="ru"){?>Деградация производительности<?}} 
													else{if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}}?></td>
									</tr>
									<tr>
										<td><img src=<?if($seg_e==1){?> "/project/tscloud/files/notification_warning.png"<?}else{?> "/project/tscloud/files/ok2.png"<?}?>></td>
										<td><?if($language=="en"){?>Storages<?} elseif($language=="ru"){?>Система хранения данных<?}?></td>
										<td id="td"><?if ($seg_e==1) {if($language=="en"){?>Performance issues<?}elseif($language=="ru"){?>Деградация производительности<?}} 
													else{if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}}?></td>
									</tr>
									<tr>
										<td><img src=<?if($seg_f==1){?> "/project/tscloud/files/notification_warning.png"<?}else{?> "/project/tscloud/files/ok2.png"<?}?>></td>
										<td><?if($language=="en"){?>Virtual environment<?} elseif($language=="ru"){?>Среда виртуализации<?}?></td>
										<td id="td"><?if ($seg_f==1) {if($language=="en"){?>Performance issues<?}elseif($language=="ru"){?>Деградация производительности<?}} 
													else{if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}}?></td>
									</tr>
									<tr>
										<td><img src=<?if($seg_f==1){?> "/project/tscloud/files/notification_warning.png"<?}else{?> "/project/tscloud/files/ok2.png"<?}?>></td>
										<td><?if($language=="en"){?>Monitoring system<?} elseif($language=="ru"){?>Система мониторинга<?}?></td>
										<td id="td"><?if ($seg_f==1) {if($language=="en"){?>Performance issues<?}elseif($language=="ru"){?>Деградация производительности<?}} 
													else{if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}}?></td>
									</tr>
									<tr>
										<td colspan="3">
											<br>
											<hr>
																							
											<img src="/project/tscloud/files/ok2.png" title="<?if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}?>" style="vertical-align:middle"> <?if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<img width="20px" src="/project/tscloud/files/notification_warning.png"  style="vertical-align:middle" title="<?if($language=="en"){?>Performance issues<?} elseif($language=="ru"){?>Деградация производительности<?}?>">&nbsp;&nbsp;<?if($language=="en"){?>Performance issues<?} elseif($language=="ru"){?>Деградация производительности<?}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<img width="20px" src="/project/tscloud/files/button_cancel.png"  style="vertical-align:middle" title="<?if($language=="en"){?>Total issue<?} elseif($language=="ru"){?>Проблема<?}?>">&nbsp;&nbsp;<?if($language=="en"){?>Total issue<?} elseif($language=="ru"){?>Проблема<?}?>
											</hr></br>
										</td>
									</tr>
								</tbody>
							</table>

						</div>
					</div>	 
				</div>
			</div>
			<div class="tab-content<? if($_REQUEST['subpage']=="status_history"){?>_active<? }?>"> 
				<div class="b-text_2col">
					<div class="tabs-content b-text">
					<div class="tab-content_wrap"> 
					<div id="screen">
						<table id="tscloud_hist_status_table">
							<tbody>
								<tr>
									<td>
										<!-- First section of the table: service names, and top arrow -->
										<table id="EUstatusHistoryContentLeft" class="statusHistory statusHistoryContentLeft" cellspacing="5" bordercolor="black" border="2">
											<tbody>
												<tr>
													<td height="38" class="leftarrow">
														<!-- стрелка влево -->
														<img class="prev" src="/project/tscloud/files/prev.gif" alt="prev" align="right">
													</td>
												</tr>
												<tr>
													<td style="border-right: 0; padding-left: 8px; padding-right: 8px; text-align: left;">
														<?if($language=="en"){?>Computing<?} elseif($language=="ru"){?>Вычислительные мощности<?}?>
													</td>
													<td style="border-left: 0;"></td>
												</tr>
												<tr>
													<td style="border-right: 0; padding-left: 8px; padding-right: 8px; text-align: left;">
														<?if($language=="en"){?>Network equipment<?} elseif($language=="ru"){?>Сетевое оборудование<?}?>
													</td>
													<td style="border-left: 0;"></td>
												</tr>
												<tr>
													<td style="border-right: 0; padding-left: 8px; padding-right: 8px; text-align: left;">
														<?if($language=="en"){?>SAN equipment<?} elseif($language=="ru"){?>Оборудование SAN-сети<?}?>
													</td>
													<td style="border-left: 0;"></td>
												</tr>
												<tr>
													<td style="border-right: 0; padding-left: 8px; padding-right: 8px; text-align: left;">
														<?if($language=="en"){?>Communication<?} elseif($language=="ru"){?>Каналы передачи данных<?}?>
													</td>
													<td style="border-left: 0;"></td>
												</tr>
												<tr>
													<td style="border-right: 0; padding-left: 8px; padding-right: 8px; text-align: left;">
														<?if($language=="en"){?>Storages<?} elseif($language=="ru"){?>Система хранения данных<?}?>
													</td>
													<td style="border-left: 0;"></td>
												</tr>
												<tr>
													<td style="border-right: 0; padding-left: 8px; padding-right: 8px; text-align: left;">
														<?if($language=="en"){?>Virtual environment<?} elseif($language=="ru"){?>Среда виртуализации<?}?>
													</td>
													<td style="border-left: 0;"></td>
												</tr>
												<tr>
													<td style="border-right: 0; padding-left: 8px; padding-right: 8px; text-align: left;">
														<?if($language=="en"){?>Monitoring system<?} elseif($language=="ru"){?>Система мониторинга<?}?>
													</td>
													<td style="border-left: 0;"></td>
												</tr>
											</tbody>
										</table>
										<!-- End of first table section. -->
									</td>
									
									

									
									
									<!-- td style="width: 100%; vertical-align: top; padding: 0; margin: 0; text-align: left;" -->
									<td style="text-align: left;">
										<!-- Second section of the table: dates and statuses -->
										<div style="position: relative;">
											<div id="sections">
												<ul>


<?php

$time_var = time();
$time_start = strtotime("3 months ago");
$stop = 0;
$date_time_var=date("Y-m-d",$time_var);
$date_time_start=date("Y-m-d",$time_start);
	
	$result_history = mysql_query("SELECT `current_status_start_data`,`current_status_end_data`,`current_status_seg_id` FROM `tscloud-current_status` where ((`current_status_start_data` >= '$date_time_start') and (`current_status_end_data` <= '$date_time_var')) or (`current_status_end_data` >= '$date_time_start');") or die(mysql_error());
	while($r_his[]=mysql_fetch_array($result_history));
	array_pop($r_his);
	$segment_date_array=[];
	$temp_seg_array=[];
	for($i=0;$i<=count($r_his);$i++)
	{
		$temp_seg_array=explode("*",$r_his[$i][2]);
		for($m=0;$m<count($devide_array);$m++) {
			array_push($segment_date_array,$temp_seg_array[$m]);
			//print_r($sum_array);
		}
	
	
	
	}
	
	/*while($result_history=mysql_fetch_array()
		$segments=explode("*",current_status_seg_id)
		foreach segments{
			//прибвляем к start дате 1 день
			сравниваем с end date с помощью while
			если равно означает стоп цикл;$wd_data[segment][дата]=1;
			если не равно продолжаем
		}
		
	
	*/
	
if($language=="ru"){
	$monthes = array(
		1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
		5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
		9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
	);
} elseif($language=="en"){
	$monthes = array(
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
	);
}
for ( $i=1; ($time_start <= $time_var) & ($stop != 1); $time_var=$time_var - 86400, $i++ )
{
//	$date = (date('d ', $time_var) . $monthes[(date('n', $time_var))] );
	$date = (date('d ', $time_var));
	$month = ($monthes[(date('n', $time_var))]);
	$date_history=date("Y-m-d",$time_var+86400);
	
	if ( $i == 1 )
		{
			echo "
													<li style=\"padding-left: 0; background-image: none;\">
														<table id=\"HistoryContent\">
															<tbody>
																<tr>\n";
		}
			echo "
																	<td>$date<br><span class=\"HeaderMonth\">$month</span></td>\n";

	if ( $i == 7 | $time_var <= ($time_start + 86400*$i) )
		{
		$date_history=date("Y-m-d",$time_var);
			echo "
																</tr>\n";
			for ( $l=1; $l <= 7; $l++)
			{
			
			echo 			"
																<tr>\n";
				for ( $k=1; $k <= $i; $k++)
					{
					echo 	"
																	<td>
																		<!-- Status Content -->
																		<img src=\"/project/tscloud/files/ok2.png\">
																		<!-- End Status Content -->";
					//print($date_history);
					echo "												</td>\n";
					}
				echo "
																</tr>\n";
			}
			if ( $i != 7 )
				{
					$stop = 1;
				}
			$i=0;
		echo "
															</tbody>
														</table>
													</li>\n";
			
			
		}

}								
?>


												</ul>
											</div>
										</div>
										  

										<!-- End of second table section -->
									</td>
									
									
									
									
									<td>
										<!-- Third section of the table: end column -->
										<table id="EUstatusHistoryContentRight" class="statusHistory statusHistoryContentRight" cellspacing="0">
											<tbody>
											
												<tr>
													<td height="38">
														<img class="next" src="/project/tscloud/files/next.gif" alt="next">
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
											</tbody>
										</table> 
										<!-- End of third table section -->
									</td>
								</tr>
							</tbody>
							
						</table>
					</div>
					<?print_r($r_his);?><br><?
							print_r($temp_seg_array);
							print_r($sum_array);
							?>
							</div>
					</div>


			
				
				</div>
			</div>
			<div class="tab-content<? if($_REQUEST['subpage']=="futureworks"){?>_active<? }?>"> 
<?
if($language=="ru"){
	$monthes = array(
		1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
		5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
		9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
	);
} elseif($language=="en"){
	$monthes = array(
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
	);
}
?>
				<div class="b-page b-text">
					<?
					// Creating array that contains rows from MySQL(start and stop date and etc)
					$today_current_status = date("Y-m-d H:i:s");					
					//echo $today_current_status;
					$result = mysql_query("SELECT * FROM `tscloud-current_status` where (`current_status_start_data` >= '$today_current_status') OR ((`current_status_start_data` <= '$today_current_status') and (`current_status_end_data` >= '$today_current_status')) ;") or die(mysql_error());
					while($r[]=mysql_fetch_array($result));
					array_pop($r);
					
					// End of Creating array
					?>
					<?
//print_r ($r[4][5]);
//$devide_array=explode("*",$r[4][5]);
//print_r($devide_array);
//echo count($devide_array);


					?>	
					<?
					if( count($r) > 0){
						?>
						<?
						// Checking each elements of array
						for ($i = 0; $i<count($r); $i++) { 
						$devide_array=explode("*",$r[$i][5]);
						?>
						<div id="content">
							<div class="b-other-projects b-text mb services_item">
							<div class="wrap">            
							<h2><?if($language=="en"){?>Scheduled workes<?} elseif($language=="ru"){?>Регламентные работы<?}?></h2>
							<div class="b-text_2col">
							<table>
							<tbody><!--tr><td>Производитель</td><td width="30px"><b>:</b></td><td><a href="/?page=swpshop&pagetype=show_vendor&vendor_id=4&menu=services_4">ServiceNow Inc</a></td></tr-->			
							<tr><td id="td" width="130" height="30"><?if($language=="en"){?>System segments<?} elseif($language=="ru"){?>Сегменты системы<?}?></td><td width="20px"><b>:</b></td><td><?
							$str_seg_name="";
							for($q=0;$q<count($devide_array);$q++) {
								if($devide_array[$q]==1) {if($language=="en"){$str_seg_name.="\"Computing\" , ";}elseif($language=="ru"){$str_seg_name.="\"Вычислительные мощности\" , ";}}
								elseif($devide_array[$q]==2){if($language=="en"){$str_seg_name.="\"Network equipment\" , ";}elseif($language=="ru"){$str_seg_name.="\"Сетевое оборудование\" , ";}}
								elseif($devide_array[$q]==3){if($language=="en"){$str_seg_name.="\"SAN equipment\" , ";}elseif($language=="ru"){$str_seg_name.="\"Оборудование SAN-сети\" , ";}}
								elseif($devide_array[$q]==4){if($language=="en"){$str_seg_name.="\"Communication\" , ";}elseif($language=="ru"){$str_seg_name.="\"Каналы передачи данных\" , ";}}
								elseif($devide_array[$q]==5){if($language=="en"){$str_seg_name.="\"Storages\" , ";}elseif($language=="ru"){$str_seg_name.="\"Система хранения данных\" , ";}}
								elseif($devide_array[$q]==6){if($language=="en"){$str_seg_name.="\"Virtual environment\" , ";}elseif($language=="ru"){$str_seg_name.="\"Среда виртуализации\" , ";}}
								elseif($devide_array[$q]==7){if($language=="en"){$str_seg_name.="\"Monitoring system\" , ";}elseif($language=="ru"){$str_seg_name.="\"Система мониторинга\" , ";}}
							}
							echo substr($str_seg_name, 0, strlen($str_seg_name) - 2) ;
							?></td></tr>
							<tr><td id="td" height="25"><?if($language=="en"){?>Time of start<?} elseif($language=="ru"){?>Время начала<?}?></td><td><b>:</b></td><td><?echo date(" H:i j ",strtotime($r[$i][1]));print($monthes[date("n",strtotime($r[$i][1]))]);echo date(" Y ",strtotime($r[$i][1]));?></td></tr>
							<tr><td id="td" height="25"><?if($language=="en"){?>Time of end<?} elseif($language=="ru"){?>Время окончания<?}?></td><td><b>:</b></td><td><?echo date(" H:i d ",strtotime($r[$i][3]));print($monthes[date("n",strtotime($r[$i][3]))]);echo date(" Y",strtotime($r[$i][3]));?></td></tr>
							<tr><td></td><td></td><td></td></tr>
							<?if($r[$i][8]!=""){?>
							<tr><td id="td"><?if($language=="en"){?>Comments<?} elseif($language=="ru"){?>Комментарий<?}?></td><td><b>:</b></td><td><?if($language=="en"){echo $r[$i][9];} elseif($language=="ru"){echo $r[$i][8];}?></td></tr>
							<?
							}
							?>
							</tbody></table>
							</div></div></div>
							
						</div>
						<? } 
						// END of checking the array
						?>
						<?
					}
					else {
						?>
						<p><?if($language=="en"){?>Time windows for works have not been scheduled<?} elseif($language=="ru"){?>Работы не запланированы<?}?></p><br><br><br><br><br><br><br><br>
						<?
					}
					?>
					
					
				</div>
			</div>
		</div>
	</div>
</div>
</div>