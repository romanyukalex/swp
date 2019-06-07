<?php
 /*******************************************************************
  * Snippet Name : module template           					 	*
  * Scripted By  : RomanyukAlex		           					 	*
  * Website      : http://popwebstudio.ru	   					 	*
  * Email        : admin@popwebstudio.ru     					 	*
  * License      : GPL (General Public License)					 	*
  * Purpose 	 : some functions								 	*
  * Access		 : include this script, insert_module("modulename")	*
  ******************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
	/*$actions_data_q=mysql_query("SELECT * FROM `$tableprefix-actions` WHERE 1;");
	while ($actions_data=mysql_fetch_array($actions_data_q)){
		$actions_array[$actions_data['date']]=$actions_data['act_title'];
	}*/
	if($param[1]=="get_next_action_date" or $param[1]=="get_next_action_title" 
		or $param[1]=="get_next_action_descr"or $param[1]=="get_next_action_id"){
		$curdate=date("Y-m-d");
		$need_type=process_data($param[2],20);
		
		$action_data=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-actions` WHERE `type_code`='$need_type' AND `date`>='$curdate' ORDER BY `date` ASC LIMIT 1;"));
		if(!$action_data){
		
		}
		if($param[1]=="get_next_action_date") return $action_data['date'];
		elseif($param[1]=="get_next_action_title") return $action_data['act_title'];
		elseif($param[1]=="get_next_action_descr") {global $language; return $action_data['act_descr_'.$language];}
		elseif($param[1]=="get_next_action_id") {return $action_data['act_id'];}
	}
	elseif($param[1]=="get_actions_data_by_type"){
		#
		$need_type=process_data($param[2],50);
		$actions_data=mysql_query("SELECT * FROM `$tableprefix-actions` a,`$tableprefix-actions-types` t WHERE t.`type_code`='$need_type' AND a.`type_code`=t.`type_code`;");
		if(!$actions_data){
		}
		return $actions_data;
	}
	elseif($param[1]=="get_actions_data_by_action_id"){
		#
		$need_act=process_data($param[2],20);
		$action_data=mysql_query("SELECT * FROM `$tableprefix-actions` a,`$tableprefix-actions-types` t WHERE a.`act_id`='$need_act' AND a.`type_code`=t.`type_code`;");
		return $action_data;
	}
	elseif($_REQUEST['act']=="show_action"){
		echo "Покажем страничку мероприятия";
	}
	elseif($_REQUEST['action']=="show_action_type"){
		echo "Покажем страничку типа";
	}
 }?>