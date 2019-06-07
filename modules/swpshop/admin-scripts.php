<?php
 /****************************************************************
  * Snippet Name : admin scripts     					 		 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : admin purposes								 *
  * Access		 : include									 	 *
  ***************************************************************/
$log->LogDebug("Got ".(__FILE__));
  if($block!==1 and $adminpanel==1){
	include_once($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/config.php");
	
	?>
	
	<a>Продукты</a><br>
	<a>Производители</a><br>
	<a>Заказы и подписки</a><br>
	
	<div id="<?=$modulename?>_messages"></div>
		<div id="templates_management_container" style="border-left: solid white; background: white;display: none;">
			<table id="<?=$modulename?>_product_table" align="center" class="zebra">
				<tr id="th"></tr>
		
		
			</table>
		</div>
		<script>
		$(document).ready(function(){
			get_table_data("<?=$modulename?>","get_products","<?=$modulename?>_messages","<?=$modulename?>_product_table");
		})
		</script><?
}
