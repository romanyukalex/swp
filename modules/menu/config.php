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
//$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__)); // крашит вэб
if ($nitka=="1"){
	$modulename="menu";
	$module_description="menu";
	global $tableprefix;
	$moduletableprefix=$tableprefix;
 }
?>