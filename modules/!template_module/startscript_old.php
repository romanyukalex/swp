<?php
/************************************************************************************
 * Snippet Name : module start script        					 					* 
 * Scripted By  : RomanyukAlex		           					 					* 
 * Website      : http://popwebstudio.ru	   					 					* 
 * Email        : admin@popwebstudio.ru     					 					* 
 * License      : GPL (General Public License)					 					* 
 * Purpose 		: page for start this module					 					*
 * Access		: create page with pagepath=/modules/modulename/startscript.php 	*
 ***********************************************************************************/
$log->LogDebug("Got ".(__FILE__));
if($nitka=="1"){
	insert_module("modulename");
}
?>