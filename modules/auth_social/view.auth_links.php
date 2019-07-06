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
if ($nitka=='1'){
	foreach ($adapters as $title => $adapter) {
       // $log->LogDebug('Adapter '.$title.' is ready');
        ?><a id="auth_social_<?=$title?>_link" href="<?=$adapter->getAuthUrl()?>"><img src="/modules/<?=$modulename?>/lib/pics/rousq/<?=$title?>.png" width="80px"></a><?
    }
}
?>