<?php
 /***************************************************************************************************************************************
  * Snippet Name : module template           					 																		*
  * Scripted By  : RomanyukAlex		           					 																		*
  * Website      : http://popwebstudio.ru	   					 																		*
  * Email        : admin@popwebstudio.ru     					 																		*
  * License      : GPL (General Public License)					 																		*
  * Purpose 	 : some functions								 																		*
  * Access		 : You can use it twice and more for diff div and with diff addition:													*
  * insert_module("add_to_copy","#content","<br>Подробнее: <a href="'+window.location.href+'">'+window.location.href+'</a>",letter_num)	*
  **************************************************************************************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
$target_block=$param[1];
$html_addtn=$param[2];
$min_letters=$param[3];
global $flag;
if(!$flag[$modulename]){
?><script type="text/javascript" src="/modules/<?=$modulename?>/addtocopy.js"></script>
<style> /* Style for <?=$modulename?>*/
	#ctrlcopy {
		color:transparent;
		height:1px;
		overflow:hidden;
		position:absolute;
		width:1px;
	}
</style>
<? }
$flag[$modulename]=1;?>
<script type="text/javascript">
	$(function(){
		$("<?=$target_block?>").addtocopy({htmlcopytxt: '<?=$html_addtn?>', minlen:<?=$min_letters?>, addcopyfirst: false});
	});
</script>

<? }?>