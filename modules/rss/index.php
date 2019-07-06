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

$modulename='rss';
$moduleflag=1;
include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts.php');
$log->LogInfo("Got ".(__FILE__));

insert_module("$modulename","get_rss_news");

/*
Раскрутка
http://feedshark.brainbliss.com/
http://www.submitrssfeed.com/
http://www.dummysoftware.com/rsssubmit.html
*/
?>