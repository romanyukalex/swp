<?php
 /***************************************************************************
  * Snippet Name : start-site-subscribe (ajax part) 			 			* 
  * Scripted By  : RomanyukAlex		           					 			* 
  * Website      : http://popwebstudio.ru	   					 			* 
  * Email        : admin@popwebstudio.ru     					 			* 
  * License      : GPL (General Public License)					 			* 
  * Purpose 	 : Insert subscription into "start-site-subscribers" table	*
  **************************************************************************/
 $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
@include_once($_SERVER["DOCUMENT_ROOT"]."/core/functions/process_user_data.php");


if($_REQUEST['chid'] and $_SESSION['checksubsribeform']==process_data($_REQUEST['chid'],7)){
	include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	@require_once($_SERVER["DOCUMENT_ROOT"]."/core/system-param.php");
	$subscr_email=process_data($_REQUEST['email'],100);
	$searchemail=mysql_query("SELECT `subscriber_id` FROM `$tableprefix-start-site-subscribers` WHERE `email`='$subscr_email' and `domain`='$sitedomainname';");
	$searchemail_count=mysql_num_rows($searchemail);
	if($searchemail_count=='0'){
		$insertemail=mysql_query("INSERT INTO `$tableprefix-start-site-subscribers` (`email` ,`subscription_ts` ,`domain` )
		VALUES ('$subscr_email', CURRENT_TIMESTAMP , '$sitedomainname');");
		if($insertemail) { # Удачная подписка
		
			if ($newsubscrmailnotify){# Нужно оповещение админов по емейл
				insert_function("send_letter");
				$subject="[".$sitedomainname."] Новый подписчик модуля ".$modulename;
				$message=$subscr_email;
				sendletter($newsubscrmailnotify,$subject,$message);
			}
			echo sitemessage("start_site_subscribe","successfully_inserted");
		} else echo sitemessage("start_site_subscribe","DB_issue");
		$_SESSION['checksubsribeform']=rand(5,5555555);
	} else {echo sitemessage("start_site_subscribe","email_already_exists");}
}
else echo sitemessage("start_site_subscribe","trying_failed");
?>
<? } ?>