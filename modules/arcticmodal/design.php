<?php
 /****************************************************************
  * Snippet Name : module template           					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : some functions								 *
  * Access		 : include									 	 *
  ***************************************************************/
$log->LogInfo("Got ".(__FILE__));
if ($nitka=="1"){
?><script src="/modules/arcticmodal/jquery.arcticmodal-0.3.min.js"></script>
<link rel="stylesheet" href="/modules/arcticmodal/jquery.arcticmodal-0.3.css">
<link rel="stylesheet" href="/modules/arcticmodal/themes/simple.css">
<script>
function hide_modal(){
	$(".box-modal").arcticmodal('close');
}
</script>
<? } ?>