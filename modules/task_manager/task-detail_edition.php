<? if($userrole!=="guest"){
include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
//include_once($_SERVER["DOCUMENT_ROOT"]."/IPreal.php");
//require($_SERVER["DOCUMENT_ROOT"]."/siteconfig.php");
//require($_SERVER["DOCUMENT_ROOT"]."/system-param.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/process_user_data.php");
$taskid=process_data($_REQUEST['taskid'],5);
//$COMMENT=process_data($_REQUEST['COMMENT'],10000);
$PRI=process_data($_REQUEST['PRI'],1);
$engineerid=process_data($_REQUEST['engineerid'],5);
$text=process_data($_REQUEST['text'],200);
$taskname=process_data($_REQUEST['taskname'],200);
//$errortext="";
/*Проверка полученного:
/// Все ли данные передались/передали?
$errfield="";$err=0;
if (empty($COMMENT)) 
	{//Если чтото из них пустое - это не все поля заполнил юзер или ошибка на сети или хакер. 
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
else{*/
	//Проверка пройдена успешно,запись данных в БД
	// Сделать запрос в БД, узнать что поменяли и делать грамотный коммент. Пока не сделано
	mysql_query("UPDATE `task-tasks` SET 
	`date` = CURRENT_TIMESTAMP() ,
	`priority` = '$PRI',
	`engineer` = '$engineerid',
	`name` = '$taskname',
	`text` = '$text' WHERE `taskid` =$taskid;");
	
	mysql_query("INSERT INTO `task-history`(`commentid`,`taskid` ,`commentdate` ,`commenttype` ,`commentuserid` ,`commenttext`)
	VALUES (NULL,'$taskid',CURRENT_TIMESTAMP,'3','$userid', 'Приоритет - $PRI, Ответственный - $engineerid, Тема задачи - $taskname, Полный текст - $text');");
	
	echo("<h2>Детали задачи успешно изменены</h2>");
//	};
}
?>