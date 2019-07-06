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
	<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=<?=$tinymceapikey?>"></script>
	<script>tinymce.init({ 
	selector:'<?=$selector?>',
	<? //if($param[3]){echo $param[3];}?>
	});</script>
<? }?>