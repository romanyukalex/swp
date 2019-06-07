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
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){?>
<script>
$(document).ready(function(){
	PreloadImg();})
function PreloadImg(){
	$.ImagePreload("files/girls002.jpg");
	$.ImagePreload("files/girls003.jpg");
	$.ImagePreload("files/girls004.jpg");
	$.ImagePreload("files/girls005.jpg");
}
</script>
<? } ?>