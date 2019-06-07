<h2><? @include($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
if ($_REQUEST[taskid] and $userrole!=="guest"){
	@include_once($_SERVER["DOCUMENT_ROOT"]."/process_user_data.php");
	$taskid=process_data($_REQUEST[taskid],6);
	$mode=process_data($_REQUEST[mode],6);
	if ($mode=="delete"){$state=2;}
	elseif ($mode=="back"){$state=1;}
	$query1=mysql_query("UPDATE `task-tasks` SET `state` = '$state' WHERE `taskid` = '$taskid'");
	if ($query1){
		if ($mode=="delete"){$modeonrus="удаление";} 
		elseif ($mode=="back"){$modeonrus="восстановление";}
		echo "Успешно выполнено ".$modeonrus." задачи ".$taskid;
		### Мылим нуждающимся ###
		$mailquerytext="SELECT u.`contactmail`,pr.`name` as projectname,`fullname`, t.`name` as shorttext,`text`
		FROM `task-projectmembers` pm, `task-users` u,`task-tasks` t,`task-projects` pr 
		WHERE t.`taskid`='$taskid' and t.`projectid`=pm.`projectid` and pm.`memberid`=u.`id` and 
		pm.`mailnotification`='1' and pr.`id`= 	t.`projectid` and t.`projectid`!='0'";
		$mailquery=mysql_query($mailquerytext);
		if($mode=="debug"){echo $mailquerytext;}
		# Формируем заголовок письма	
		$from="TTM (TechnoservTaskManager)";
		$header= "MIME-Version: 1.0\r\n";
		$header="Content-type: text/html;  charset=\"UTF-8\"\r\n";
		$header.="From: ".$from." <noreply@technoserv.com>\n";
		$header.='Reply-To: aromanyuk@technoserv.com'."\r\n";
		while($mailnotifinfo=mysql_fetch_array($mailquery)){
			$subject="[".$mailnotifinfo['projectname']."] Произведено ".$modeonrus." задачи номер ".$taskid;
			$message="<html><body>
		<img src=\"http://t.itarakan.ru/files/technoservlogo.gif\"><br>Здравствуйте, ".$mailnotifinfo['fullname']."<br> Пользователем ".$nickname." произведено $modeonrus задачи номер ".$taskid.".<br><br> <h4>Краткое описание задачи:</h4><br>".$mailnotifinfo['shorttext'];
			if ($mailnotifinfo['text']){$message.="<br><br><h4>Полное описание задачи:</h4><br>".$mailnotifinfo['text'];}
			$message.="<br><br><br><br> Если Вы видите какие либо неточности в отображении задачи, просьба сообщить <a href='mailto:aromanyuk@technoserv.com'>администатору портала</a></body></html>";
			# мылим
			@mail($mailnotifinfo['contactmail'],'=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);
			}
		} 
	else {?>Действие не выполнено (проверьте подключение к БД)<? }
}
else {?>Неверный номер задачи<? }
?></h2>
