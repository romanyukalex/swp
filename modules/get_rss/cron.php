<?php
 /*******************************************************************************
  * Snippet Name : modulename									 				*
  * Part		 : Crontab script												*
  * Scripted By  : RomanyukAlex		           					 				*
  * Website      : http://popwebstudio.ru	   					 				*
  * Email        : admin@popwebstudio.ru     					 				*
  * License      : GPL (General Public License)					 				*
  * Purpose 	 : some crontab functions						 				*
  * Access		 : insert /core/swp_cron_tasks.php into crontab					*
  * * * * * * php /var/www/html/vobla1/core/swp_cron_tasks.php project			*
  ******************************************************************************/

$log->LogInfo('Start of script -------------------');
require($this_path.'/config.php');//Конфиг модуля

$rss_task_q=mysql_query("SELECT SQL_NO_CACHE * FROM `$moduletableprefix-$modulename-conf` WHERE
`last_update`<= (NOW() - `update_freq`*60 LIMIT 0,$feed_num_once_cron
;");
if(mysql_num_rows($rss_task_q)>1){
  while($rss_task=mysql_fetch_array($rss_task_q)){
    $rss=insert_module("get_rss","get_feed",$rss_task['feed_url'],"array");
    foreach($rss as $item){
      $log->$logDebug("$item['title']"); 
    }
  }
} else $log->$logDebug("No crontab tasks for the moment");
$log->LogInfo('End of script -------------------');
		
 ?>