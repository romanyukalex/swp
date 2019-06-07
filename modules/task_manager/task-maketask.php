<?
# Добавление задачи
if ($_REQUEST["new_name"])
	{@include($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	$priority=process_data($_REQUEST["PRI"],1);
	$name=process_data($_REQUEST["new_name"],400);
	$text=process_data($_REQUEST["text"],1000);
	$projectid=process_data($_REQUEST["projectid"],5);
	mysql_query("INSERT INTO `task-tasks`(`taskid`,`projectid`, `date`, `priority`, `engineer`, `name`, `text`,`state`) 
	VALUES ('','$projectid', CURRENT_TIMESTAMP, '$priority', '$userid', '$name', '$text','1');");
	$newtaskid= mysql_insert_id();
	mysql_query("INSERT INTO `task-history` (`commentid`,`taskid`,`commentdate`,`commenttype`,`commentuserid`,`commenttext`)
	VALUES ('','$newtaskid', CURRENT_TIMESTAMP ,'1','$userid','');");
	### Мылим нуждающимся ###
	$mailquery=mysql_query("SELECT u.`contactmail`,pr.`name` as projectname,`fullname`
	FROM `task-projectmembers` pm, `task-users` u,`task-tasks` t,`task-projects` pr 
	WHERE t.`taskid`='$newtaskid' and t.`projectid`=pm.`projectid` and pm.`memberid`=u.`id` and pm.`mailnotification`='1' and pr.`id`= t.`projectid` and t.`projectid`!='0'");
	# Формируем заголовок письма	
	//$from=substr($companyname,0,1)."TM (".$companyname."TaskManager)";
	$from="TaskManager";
	$header= "MIME-Version: 1.0\r\n";
	$header.="Content-type: text/html;  charset=\"UTF-8\"\r\n";
	$header.="From: ".$from." <noreply@".$domain.">\r\n";
	$header.='Reply-To: noreply@'.$domain."\r\n";
	while($mailnotifinfo=mysql_fetch_array($mailquery)){
		$subject="[".$mailnotifinfo['projectname']."] Создана новая задача номер ".$newtaskid;
		$message="<html><body>
		<img src=\"http://$domain/$logofile\"><br><br>Здравствуйте, ".$mailnotifinfo['fullname']."<br> Пользователем ".$nickname." создана новая задача номер ".$newtaskid." (Приоритет ".$priority.").<br><br> <h4>Краткое описание задачи:</h4><br>".$name;
		if ($text){$message.="<br><br><h4>Полное описание задачи:</h4><br>".$text;}
		$message.="<br><br><br><br> Если Вы видите какие либо неточности в отображении задачи, просьба сообщить <a href='mailto:aromanyuk@technoserv.com'>администатору портала</a></body></html>";
		# мылим
		@ mail($mailnotifinfo['contactmail'], '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);
	}
	if($gettype=="ajax"){echo "<h2>Задача успешно добавлена</h2>";}// если запрос из ajax, надо оповестить юзера об усп. добавлении
}?>