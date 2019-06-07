<? require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
require($_SERVER["DOCUMENT_ROOT"]."/IPreal.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/process_user_data.php");
$taskid=process_data($_REQUEST['taskid'],5);
$COMMENT=process_data($_REQUEST['COMMENT'],10000);
$errortext="";
//Проверка полученного:
/// Все ли данные передались/передали?
$errfield="";$err=0;
if (empty($COMMENT)) 
	{/*Если чтото из них пустое - это не все поля заполнил юзер или ошибка на сети или хакер. */
	$err=1;$errortext.="Заполните обязательные поля<br>";
	}
if ($COMMENT=="Новая запись")
	{
	$err=5;$errortext.="Не заполен текст комментария<br>";
	}
if ($err!==0)
	{//Проверка пройдена неуспешно
	echo "<h2 style='color:red'>".$errortext."</h2>";
	}	
else{//Проверка пройдена успешно,запись данных в БД
	if (!$_REQUEST[sendletters]){
		### Мылим нуждающимся ###
		$mailquery=mysql_query("SELECT u.`contactmail`,pr.`name` as projectname,`fullname`, t.`name` as shorttext
		FROM `task-projectmembers` pm, `task-users` u,`task-tasks` t,`task-projects` pr 
		WHERE t.`taskid`='$taskid' and t.`projectid`=pm.`projectid` and pm.`memberid`=u.`id` and pm.`mailnotification`='1' and pr.`id`= t.`projectid` and t.`projectid`!='0'");
		$HTMLCOMMENT=str_replace("\n","<br>",$COMMENT);
		$sendletters="3"; //Написать в БД, что письма некому отправлять, если в while не исправят
		while($mailnotifinfo=mysql_fetch_array($mailquery)){
			# Формируем заголовок письма
			$from="TechnoservTaskManager";
			$subject="[".$mailnotifinfo['projectname']."] Новый комментарий к задаче номер ".$taskid;
			$header="Content-type: text/html;  charset=utf-8\n";
			$header.="From: ".$from." <noreply@technoserv.com>\n";
			//$header.="Subject: ".$subject."\n";
			$message="Здравствуйте, ".$mailnotifinfo['fullname']."<br> К задаче номер ".$taskid." пользователь ".$nickname." добавил новый комментарий.<br><br> <h4>Краткое описание задачи:</h4><br>".$mailnotifinfo['shorttext']."<br><br><h4>Текст комментария:</h4><br>".$HTMLCOMMENT."<br><br><br><br> Если Вы видите какие то неточности в отображении комментария, просьба сообщить <a href='mailto:aromanyuk@technoserv.com'>администатору портала</a>";
			# мылим
			@ mail($mailnotifinfo['contactmail'], '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);
			$sendletters="1"; //Написать в БД, что письма отправлены
			}
		}
	else{$sendletters="2";/*Команда 'не уведомлять' от пользователя*/}
	mysql_query("INSERT INTO `task-history` (`commentid`,`taskid`,`commentdate`,`commentuserid`,`commenttext`,`letter`)
	VALUES ('','$taskid', CURRENT_TIMESTAMP ,'$userid','$COMMENT','$sendletters');");
	echo("<h2>Комментарий успешно загружен</h2>");
	}
?>