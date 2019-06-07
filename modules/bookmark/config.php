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
  # $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__)); ------- эта строчка крашит вэб
if ($nitka=="1"){
	$moduletype="bookmark";
	$module_description="Мультибраузерная функция добавления в закладки";
	$modulename=$moduletype;
	$moduletableprefix=$tableprefix;
	//$javascripts=array("ATBookmarkApp.js");
 }
?>