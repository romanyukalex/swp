<?php
/************************************************************************************
 * Snippet Name :      					 					* 
 * Scripted By  : RomanyukAlex		           					 					* 
 * Website      : http://popwebstudio.ru	   					 					* 
 * Email        : admin@popwebstudio.ru     					 					* 
 * License      : GPL (General Public License)					 					* 
 * Purpose 		: page for start this module					 					*
 * Access		: 	*
 ***********************************************************************************/
$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Got login_script");
 if($nitka=="1"){
	insert_function("collect_data");
	$balancerip="ocean1.rxs77.net";
	$balancerport="58080";
	/* 
	//Создать пользователя
	
	$api="admin"; $cmd="user/add";
	
	$postData=array('domain'=>'ktopomozhet.ru',
	"loginName"=>"aromanuk#mail.ru",
	"password"=>"12345678",
	"firstName"=>"Alexey",
	"middleName"=>"O",
	"lastName"=>"Romanyuk");
	
	$json = json_encode($postData);
	
	// Удалить пользователя
	$api="admin"; $cmd="user/delete?loginName=aromanuk#mail.ru";
	
	// Добавить роль
	$api="admin"; $cmd="user/grantrole?loginName=aromanuk#mail.ru&role=master";
	
	$api="admin"; $cmd="user/grantrole?loginName=operator&role=operator";
	
	// Удалить роль
	$api="admin"; $cmd="user/revokerole?loginName=aromanuk#mail.ru&role=master";
	
	//Получить список нераспределенных задач
	$api="operator"; $cmd="unassignedtasks";

	//Получить детали по задаче
	$api="operator"; $cmd="gettask";	$json='{"taskId":"24"}';

	//GET ALL USERS
	$api="operator"; $cmd="allusers";

	//Информация по исполнителю (не работает пока)
	$api="operator"; $cmd="masterinfo/?loginName=aromanuk#mail.ru@ktopomozhet.ru";
	*/
	
	$api="operator"; $cmd="allusers";
	
	
	
	if($api=="admin"){$basicauthuser="admin@ktopomozhet.ru";$basicauthpwd="123";}
	elseif($api=="master"){$basicauthuser="aromanuk#mail.ru@ktopomozhet.ru";$basicauthpwd="123";}
	elseif($api=="operator"){$basicauthuser="operator@ktopomozhet.ru";$basicauthpwd="87654321";}
	//echo $answer_json=collect_data("MobileMaster/api/$api",$cmd,$json);
	

	$answer_obj=json_decode($answer_json);
	echo $answer_obj;
	
	
	
	
	
	
	
	
	
	
	
	$last_line = system("ps -aux", $retval);
	echo $retval;
	
	
	
	
	
	
	
	
}
?>