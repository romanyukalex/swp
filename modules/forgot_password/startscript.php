<?php
/************************************************************************************
 * Snippet Name : module start script        					 					* 
 * Scripted By  : RomanyukAlex		           					 					* 
 * Website      : http://popwebstudio.ru	   					 					* 
 * Email        : admin@popwebstudio.ru     					 					* 
 * License      : GPL (General Public License)					 					* 
 * Purpose 		: page for start this module					 					*
 * Access		: create page with page_module=forgot_password					 	*
 ***********************************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
  insert_module("forgot_password");
}
?>