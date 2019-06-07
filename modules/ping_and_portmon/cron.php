<?php
 /*******************************************************************************
  * Snippet Name : ping and monitor crontab script				 				*
  * Scripted By  : RomanyukAlex		           					 				*
  * Website      : http://popwebstudio.ru	   					 				*
  * Email        : admin@popwebstudio.ru     					 				*
  * License      : GPL (General Public License)					 				*
  * Purpose 	 : some functions								 				*
  * Access		 : insert this script into crontab and set a project			*
  * * * * * * php /var/www/html/vobla1/modules/ping_and_portmon/cron.php tscloud*
  ******************************************************************************/

$nitka=1;
echo "Start monitor\n";
$breakthisfile = Explode('/', $_SERVER["SCRIPT_NAME"]);
unset ($breakthisfile[count($breakthisfile)-1]); //Удалили название скрипта
$this_path=implode('/', $breakthisfile); 
if($breakthisfile[count($breakthisfile)-1]!=="modules")unset ($breakthisfile[count($breakthisfile)-1]); //Мы все еще в глубине файловой системы, удаляем папку с модулем
unset ($breakthisfile[count($breakthisfile)-1]); //Удаляем /modules
$_SERVER["DOCUMENT_ROOT"]=implode('/', $breakthisfile); // Домашняя директория всего сайта

require($_SERVER["DOCUMENT_ROOT"]."/core/start_platform_scripts_cron.php");
require($this_path."/config.php");//Конфиг модуля

$nodes_q=mysql_query("SELECT * FROM `$tableprefix-monitor-nodes` WHERE `mon_status`='active';");//Узлы для мониторинга

include($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/Ping.php");//Класс мониторинга




while ($nodes_info=mysql_fetch_array($nodes_q)){
	
	if(!$ping) $ping = new Ping($nodes_info['ipaddr']);
	else {
		$newhost=$ping->setHost($nodes_info['ipaddr']);
		$newhost=$ping->setPort($nodes_info['port']);
	}
	if($nodes_info['mon_type']=="ping"){$nodes_info['mon_type']="exec";}
	
	$latency = $ping->ping($nodes_info['mon_type']);
	if ($latency !== false) {# OK
		echo "HOST ".$ping->getHost().":".$nodes_info['port']." answered after ".$latency." ms\n";
		$newstatus[$nodes_info['node_id']]="alive";
		$latencys[$nodes_info['node_id']]=$latency;
	}
	else { #NOK
		echo "HOST ".$ping->getHost().": unavailable\n";
		$newstatus[$nodes_info['node_id']]="dead";
		$latencys[$nodes_info['node_id']]="dead";
	}
	if ($newstatus[$nodes_info['node_id']]!==$nodes_info['cur_status']){// Статус изменился
		#Cur_status update
		$cst_upd_q=mysql_query("UPDATE `$tableprefix-monitor-nodes` SET `cur_status` = '".$newstatus[$nodes_info['node_id']]."' WHERE `node_id` = '".$nodes_info['node_id']."';");
		if($cst_upd_q) $log->LogDebug($modulename."/cron | ".(__LINE__)." | Node ".$nodes_info['node_id']." (".$ping->getHost().":".$nodes_info['port'].") new current status (".$newstatus[$nodes_info['node_id']].") was updated in DB");
		else $log->LogDebug($modulename."/cron | ".(__LINE__)." | Node ".$nodes_info['node_id']." (".$ping->getHost().":".$nodes_info['port'].") new current status was NOT updated in DB");
		#Event history
		$evhist_q=mysql_query("INSERT INTO `$tableprefix-monitor-events` 
		(`event_id` ,`node_id` ,`event` ,`event_date` ,`comment` )VALUES 
		(NULL , '".$nodes_info['node_id']."', '".$newstatus[$nodes_info['node_id']]."', CURRENT_TIMESTAMP , NULL );");
		if($evhist_q) $log->LogDebug($modulename."/cron | ".(__LINE__)." | Node ".$nodes_info['node_id']." (".$ping->getHost().":".$nodes_info['port'].") event was inserted into DB");
		else $log->LogDebug($modulename."/cron | ".(__LINE__)." | Node ".$nodes_info['node_id']." (".$ping->getHost().":".$nodes_info['port'].") event was NOT inserted into DB");
		$changed_statuses[$nodes_info['node_id']]=$newstatus[$nodes_info['node_id']];
	}
}
foreach ($latencys as $Key => $Value) $latencystr .= "node ".$Key . ' = ' . $Value.",";
$log->LogDebug($modulename."/cron | ".(__LINE__)." | Results of measuring: ".substr($latencystr,0,-1));
if($scr_aft_mon){include($_SERVER["DOCUMENT_ROOT"]."/project/".$projectname."/scripts/".$scr_aft_mon);}
$log->LogInfo($modulename."/cron | End of script -------------------");
		
 ?>