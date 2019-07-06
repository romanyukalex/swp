<? $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__)); ?>
<? if($_REQUEST['action']=="deactivate" and $nitka=="1"){
	include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/core/system-param.php");
	$deactivationlink=process_data($_REQUEST['deactivationlink'],15);
	
	$deactivuser=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` u,`$companiesprefix-companies` c WHERE `DeactivationLink`='$deactivationlink' and `status`='created' LIMIT 0 , 1"));
	
	?><div id="regform_answer" class="checkbox-radio-css3-show"><?
	if($deactivuser['userid']){// Пользователь найден
		$deactivateuserreq=mysql_query("DELETE `$tableprefix-users`  WHERE `userid` ='$deactivuser[userid]';");
		if($deactivateuserreq){ // ДеАктивирован
			echo sitemessage("registration_form","success_deactivation");}
	} else {echo sitemessage("registration_form","failed_deactivation");}
	?></div><?
}
?>