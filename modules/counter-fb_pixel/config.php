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
# $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__)); -- крашит вэб
if ($nitka=="1"){  
  $moduletype="counter-fb_pixel";
  $module_description="Facebook pixel Counter";
  $modulename=$moduletype;
  $moduletableprefix=$tableprefix;
} ?>