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
		<div id="notistoria" class="tab-label tab-label_<? if($_REQUEST['subpage']=="curstatus"){?>_active<? }else{?>_last<?}?>"><a href="/?page=tscloud_status&menu=tscloud&subpage=curstatus"><?if($language=="en"){?>Current state<?} elseif($language=="ru"){?>Текущее состояние<?}?></a></div>
		<div id="notistoria1" class="tab-label tab-label_<? if($_REQUEST['subpage']=="status_history"){?>_active<? }else{?>_last<?}?>"><a href="/?page=tscloud_status&menu=tscloud&subpage=status_history"><?if($language=="en"){?>Month history<?} elseif($language=="ru"){?>История за месяц<?}?></a></div>
		<div id="notistoria2" class="tab-label tab-label_<? if($_REQUEST['subpage']=="futureworks"){?>_active<? }else{?>_last<?}?> tab-label_next"><a href="/?page=tscloud_status&menu=tscloud&subpage=futureworks"><?if($language=="en"){?>Scheduled works<?} elseif($language=="ru"){?>Запланированные окна выполнения работ<?}?></a></div>
	</div>
	<div class="b-tabs2"></div>
	<div class="tabs-content b-text"> 
		<div class="tab-content_wrap"> 
			<div class="tab-content tab-content<? if($_REQUEST['subpage']=="curstatus"){?>_active<? }?>"> 
				<div class="b-other-projects b-text mb">
					<div class="wrap">             
						<div class="b-text_2col">
							<table cellspacing="0" id="tscloud_cur_status_table" class="fullWidth">
								<thead>
									<tr>
										<th colspan="2" style="width: 300px;" class="left gradient"><?if($language=="en"){?>Current status<?} elseif($language=="ru"){?>Текущий статус<?}?>:</th>
										<th style="padding-left: 8px"><?if($language=="en"){?>Detailed<?} elseif($language=="ru"){?>Детали<?}?></th>	  
									</tr>
								</thead>
								<tbody>         
									<tr>
										<td><img src="/project/tscloud/files/ok2.png"></td>
										<td><?if($language=="en"){?>Computing<?} elseif($language=="ru"){?>Вычислительные мощности<?}?></td>
										<td><?if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}?></td>
									</tr>
									<tr>
										<td><img src="/project/tscloud/files/ok2.png"></td>
										<td><?if($language=="en"){?>Network equipment<?} elseif($language=="ru"){?>Сетевое оборудование<?}?></td>
										<td><?if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}?></td>
									</tr>
									<tr>
										<td><img src="/project/tscloud/files/ok2.png"></td>
										<td><?if($language=="en"){?>SAN equipment<?} elseif($language=="ru"){?>Оборудование SAN-сети<?}?></td>
										<td><?if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}?></td>
									</tr>
									<tr>
										<td><img src="/project/tscloud/files/ok2.png"></td>
										<td><?if($language=="en"){?>Communication<?} elseif($language=="ru"){?>Каналы передачи данных<?}?></td>
										<td><?if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}?></td>
									</tr>
									<tr>
										<td><img src="/project/tscloud/files/ok2.png"></td>
										<td><?if($language=="en"){?>Storages<?} elseif($language=="ru"){?>Система хранения данных<?}?></td>
										<td><?if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}?></td>
									</tr>
									<tr>
										<td><img src="/project/tscloud/files/ok2.png"></td>
										<td><?if($language=="en"){?>Virtual environment<?} elseif($language=="ru"){?>Среда виртуализации<?}?></td>
										<td><?if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}?></td>
									</tr>
									<tr>
										<td><img src="/project/tscloud/files/ok2.png"></td>
										<td><?if($language=="en"){?>Monitoring system<?} elseif($language=="ru"){?>Система мониторинга<?}?></td>
										<td><?if($language=="en"){?>Operating normally<?} elseif($language=="ru"){?>В штатном режиме<?}?></td>
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
																		<!-- End Status Content -->
																	</td>\n";
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
					</div>
					</div>


			
				
				</div>
			</div>
			<div class="tab-content<? if($_REQUEST['subpage']=="futureworks"){?>_active<? }?>"> 
				<div class="b-page b-text">
					<p><?if($language=="en"){?>Time windows for works have not been scheduled<?} elseif($language=="ru"){?>Работы не запланированы<?}?></p><br><br><br><br><br><br><br><br>
				</div>
			</div>
		</div>
	</div>
</div>
</div>