<?php
 /*******************************************************************
  * Snippet Name : module template           					 	*
  * Scripted By  : RomanyukAlex		           					 	*
  * Website      : http://popwebstudio.ru	   					 	*
  * Email        : admin@popwebstudio.ru     					 	*
  * License      : GPL (General Public License)					 	*
  * Purpose 	 : some functions								 	*
  * Access		 : include this script, insert_module("modulename")	*
  ******************************************************************/
$log->LogDebug("Got ".(__FILE__));
if ($nitka=="1"){
	#Параметры модуля
	
	$param_array=$param[1];
	//echo $param_array['table_design'];
	
	
?> <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/base/jquery-ui.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>    
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<!--PQ Grid files-->
    <link rel="stylesheet" href="/modules/grid/pqgrid.min.css" />
    <script src="/modules/grid/pqgrid.min.js"></script>
<!--PQ Grid Office theme-->
    <link rel="stylesheet" href="/modules/grid/themes/<?=$param_array['table_design_css']?>/pqgrid.css" />
<script>
    $(function () {



	  // get_grid_data("<?=$param_array['module']?>","<?=$param_array['module_action']?>","<?=$param_array['table_id']?>_messages","<?=$param_array['table_id']?>");

		/*
		module=arguments[0];
		someaction=arguments[1];
		nok_answerplace=arguments[2];
		table_id=arguments[3];
		*/
		/*
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: '/core/ajaxapi.php',
			data: 'action=<?=$param_array['module_action']?>&mod=<?=$param_array['module']?>&rand='+Math.random(),
			success: function(){
				alert("hi");
			}
		});*/


















	
		var data = [[1, 'Exxon Mobil', '339,938.0', '36,130.0'],
            [2, 'Wal-Mart Stores', '315,654.0', '11,231.0'],
			[3, 'Royal Dutch Shell', '306,731.0', '25,311.0'],
			[4, 'BP', '267,600.0', '22,341.0'],
			[5, 'General Motors', '192,604.0', '-10,567.0'],
			[6, 'Chevron', '189,481.0', '14,099.0'],
			[7, 'DaimlerChrysler', '186,106.3', '3,536.3'],
			[8, 'Toyota Motor', '185,805.0', '12,119.6'],
			[9, 'Ford Motor', '177,210.0', '2,024.0'],
			[10, 'ConocoPhillips', '166,683.0', '13,529.0'],
			[11, 'General Electric', '157,153.0', '16,353.0'],
			[12, 'Total', '152,360.7', '15,250.0'],
			[13, 'ING Group', '138,235.3', '8,958.9'],
			[14, 'Citigroup', '131,045.0', '24,589.0'],
			[15, 'AXA', '129,839.2', '5,186.5'],
			[16, 'Allianz', '121,406.0', '5,442.4'],
			[17, 'Volkswagen', '118,376.6', '1,391.7'],
			[18, 'Fortis', '112,351.4', '4,896.3'],
			[19, 'Crédit Agricole', '110,764.6', '7,434.3'],
			[20, 'American Intl. Group', '108,905.0', '10,477.0']];


        var obj = { width: <?=$param_array['table_width']?>, height: <?=$param_array['table_height']?>, 
		title: "<?=$param_array['table_title']?>",resizable:true,draggable:true };
       		obj.colModel = [{ title: "Rank", width: 100, dataType: "integer" },
        { title: "Company", width: 200, dataType: "string" },
        { title: "Revenues ($ millions)", width: 150, dataType: "float", align: "right" },
        { title: "Profits ($ millions)", width: 150, dataType: "float", align: "right"}];
        
		
		
		obj.dataModel = { data: data };
       


	   
	   $("#grid_array").pqGrid(obj);
	   
//	   get_grid_data("<?=$param_array['module']?>","<?=$param_array['module_action']?>","<?=$param_array['table_id']?>_messages","<?=$param_array['table_id']?>");

  });
        
</script>
<div id="<?=$param_array['table_id']?>_messages"></div>
<div id="grid_array_<?=$param_array['table_id']?>"></div>


<div id="grid_array"></div>

<? }?>