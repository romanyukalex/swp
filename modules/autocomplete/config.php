<?php
 /****************************************************************
  * Snippet Name : module config 			 					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : some functions								 *
  * Access		 : just insert_module("modulename")			 	 *
  ***************************************************************/
  $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
	$modulename="autocomplete";
	$module_description="autocomplete";
	global $tableprefix;
	$moduletableprefix=$tableprefix;
 }
?>