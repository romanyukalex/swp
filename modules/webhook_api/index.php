<?php 
 /****************************************************************
  * Snippet Name : rss feeds		           					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : To show RSS feeds based on News-module		 *
  * Access		 : http://domain.com/modules/rss/				 *
  *		http://domain.com/modules/rss/?section=раздел&lang=en	 *
  ***************************************************************/

$modulename='webhook_api';
$moduleflag=1;
include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts.php');
$log->LogInfo("Got ".(__FILE__));
$action=process_data($_REQUEST['action'],30);
insert_module("$modulename","$action");

?>