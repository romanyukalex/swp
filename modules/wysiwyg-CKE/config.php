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
 $log->LogInfo("Got ".(__FILE__));
if ($nitka=="1"){
	$moduletype="wysiwyg-CKE";
	$modulename=$moduletype;
	$module_description="wysiwyg module based on CKEditor";
	$moduletableprefix=$tableprefix;
 }