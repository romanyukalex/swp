<? 
/*****************************************************************************************************************************
  * Snippet Name : adminpanel:users-management.php																					 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru	from autor		 															 *
  * Purpose 	 : 											 					 *
  * Insert		 : 														 *
  ***************************************************************************************************************************/ 

if(($userrole=="admin" or $userrole=="root") and $adminpanel==1){?>
	СТАТИСТИКА В ГРАФИКАХ<br>
	
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/lib/jqplot/jquery.jqplot.js"></script>
<script type="text/javascript" src="/js/lib/jqplot/plugins/jqplot.dateAxisRenderer.js"></script>
<script type="text/javascript" src="/js/lib/jqplot/plugins/jqplot.logAxisRenderer.js"></script>
<script type="text/javascript" src="/js/lib/jqplot/plugins/jqplot.canvasTextRenderer.js"></script>
<script type="text/javascript" src="/js/lib/jqplot/plugins/jqplot.canvasAxisTickRenderer.js"></script>
<script type="text/javascript" src="/js/lib/jqplot/plugins/jqplot.highlighter.js"></script>
<link rel="stylesheet" type="text/css" href="/js/lib/jqplot/jquery.jqplot.css" />
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" />

<script>

$(document).ready(function () {
    $.jqplot._noToImageButton = true;
    
	<? 
	
	$start_date=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
	$end_date=date("Y-m-d");
	$end_date_db=date("Y-m-d H-i");
	
	$vid_found_tday_q=mysql_query("SELECT * FROM `$tableprefix-stat-results` WHERE `paramName`='vid_found_tday' and `ts`>='$start_date' and `ts`<='$end_date_db' order by `ts` ASC;");
	$vid_needModerate_q=mysql_query("SELECT * FROM `$tableprefix-stat-results` WHERE `paramName`='vid_needModerate' and `ts`>='$start_date' and `ts`<='$end_date_db' order by `ts` ASC;");
	?>
	var vid_found_tday=[
	
	<? while($vid_found_tday=mysql_fetch_assoc($vid_found_tday_q)){?>["<?=substr($vid_found_tday['ts'],0,10)?>",<?=$vid_found_tday['result']?>],<?}
	?>
	
	]
	
	var vid_needModerate=[
	
	<? while($item=mysql_fetch_assoc($vid_needModerate_q)){?>["<?=substr($item['ts'],0,10)?>",<?=$item['result']?>],<?}
	?>
	
	]
	
    var plot1 = $.jqplot("chart1", [vid_found_tday, vid_needModerate], {
        seriesColors: ["rgba(78, 135, 194, 0.7)", "rgb(211, 235, 59)"],
        title: 'Видео, шт.',
        highlighter: {
            show: true,
            sizeAdjust: 1,
            tooltipOffset: 9
        },
        grid: {
            background: 'rgba(57,57,57,0.0)',
            drawBorder: false,
            shadow: false,
            gridLineColor: '#666666',
            gridLineWidth: 2
        },
        legend: {
            show: true,
            placement: 'outside'
        },
        seriesDefaults: {
            rendererOptions: {
                smooth: true,
                animation: {
                    show: true
                }
            },
            showMarker: false
        },
        series: [
            {
                fill: true,
                label: 'Новых видео найдено в этот день'
            },
            {
                label: 'Видео, нуждающиеся в модерации'
            }
        ],
        axesDefaults: {
            rendererOptions: {
                baselineWidth: 1.5,
                baselineColor: '#444444',
                drawBaseline: false
            }
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.DateAxisRenderer,
                tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                tickOptions: {
                    formatString: "%b %e",
                    angle: -30,
                    textColor: '#dddddd'
                },
                min: "<?=$start_date?>",
                max: "<?=$end_date?>",
                tickInterval: "7 days",
                drawMajorGridlines: false
            },
            yaxis: {
                renderer: $.jqplot.LogAxisRenderer,
                pad: 0,
                rendererOptions: {
                    minorTicks: 1
                },
                tickOptions: {
                    formatString: "%'d", // Формат обозначения на графике и на левой шкале. Можно подставить $, например
                    showMark: false
                }
            }
        }
    });
 
      $('.jqplot-highlighter-tooltip').addClass('ui-corner-all'); //Вызов первого графика
	 <? 
	 
	$need_on_graph=array(
		"vid_active",
		"book_countActive",
		"pages_artcls_db",
		"jokes_countAll"
	);
	foreach($need_on_graph as $qParam){
		
		$paramTitles[$qParam]=mysql_fetch_assoc(mysql_query("SELECT * FROM `$tableprefix-stat-conf` WHERE `paramName`='".$qParam."'"));
		$param_q=mysql_query("SELECT * FROM `$tableprefix-stat-results` WHERE `paramName`='".$qParam."' and `ts`>='$start_date' and `ts`<='$end_date_db' order by `ts` ASC;");?>
		
		var <?=$qParam?>=[
		
		<? while($item=mysql_fetch_assoc($param_q)){?>["<?=substr($item['ts'],0,10)?>",<?=$item['result']?>],<?}?>
		
		]
<? 	}?>
	
	
    var plot1 = $.jqplot("chart2", [<? foreach($need_on_graph as $qParam) {echo $qParam.",";}?>], {
        seriesColors: ["rgba(78, 135, 194, 0.7)", "rgb(211, 235, 59)"],
        title: 'Основные параметры проекта, шт.',
        highlighter: {
            show: true,
            sizeAdjust: 1,
            tooltipOffset: 9
        },
        grid: {
            background: 'rgba(57,57,57,0.0)',
            drawBorder: false,
            shadow: false,
            gridLineColor: '#666666',
            gridLineWidth: 2
        },
        legend: {
            show: true,
            placement: 'outside'
        },
        seriesDefaults: {
            rendererOptions: {
                smooth: true,
                animation: {
                    show: true
                }
            },
            showMarker: false
        },
        series: [
		
			<? foreach ($paramTitles as $paramTitle){
				?>
				{
                
                label: '<?=$paramTitle['Name']?>'
				},
				
				<?
			}
			?>
           
        ],
        axesDefaults: {
            rendererOptions: {
                baselineWidth: 1.5,
                baselineColor: '#444444',
                drawBaseline: false
            }
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.DateAxisRenderer,
                tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                tickOptions: {
                    formatString: "%b %e",
                    angle: -30,
                    textColor: '#dddddd'
                },
                min: "<?=$start_date?>",
                max: "<?=$end_date?>",
                tickInterval: "7 days",
                drawMajorGridlines: false
            },
            yaxis: {
                renderer: $.jqplot.LogAxisRenderer,
                pad: 0,
                rendererOptions: {
                    minorTicks: 1
                },
                tickOptions: {
                    formatString: "%'d", // Формат обозначения на графике и на левой шкале. Можно подставить $, например
                    showMark: false
                }
            }
        }
    });
 
      $('.jqplot-highlighter-tooltip').addClass('all_news'); //Вызов первого графика
	  
	  
});

</script>
	<div class="col1" style="width: 81%;">
	 <div class="ui-widget ui-corner-all">
        <div class="ui-widget-header ui-corner-top">Статистические данные за месяц</div>
        <div class="ui-widget-content ui-corner-bottom" >
            <div id="chart1"></div>
        </div>
    </div>
	</div>
	
	<div class="col1" style="width: 81%;">
	 <div class="ui-widget all_news">
        <div class="ui-widget-header ui-corner-top">Статистические данные за месяц</div>
        <div class="ui-widget-content ui-corner-bottom" >
            <div id="chart2"></div>
        </div>
    </div>
	</div>
	
	<?
	
}?><br><br><br><br><br><br>