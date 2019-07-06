<?php
 /**************************************************************************\
  * Snippet Name : modulename		           					 			*
  * Part		 : view (view)												*
  * Scripted By  : RomanyukAlex		           					 			*
  * Website      : http://popwebstudio.ru	   					 			*
  * Email        : admin@popwebstudio.ru     					 			*
  * License      : GPL (General Public License)					 			*
  * Purpose 	 : do something								 				*
  * Access		 : 															*
  * insert_module('modulename','get_some',$get_detail_arr)					*
  \*************************************************************************/
$log->LogDebug('Got this file');
if ($nitka=='1'){?>

<script src="https://cdn.ckeditor.com/4.11.3/<?=$param[2]?>/ckeditor.js"></script>
<script>
CKEDITOR.replace('<?=$selector?>'
  <? if($param[4]){echo ", {".$param[4]."}";}?>
);
</script>
	
	
<? }?>