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
	if($_REQUEST[action]=="show_module_data"){
		
	}
}
