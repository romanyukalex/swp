<?php 
###############################################################################################
#Скрипт для проверки стрим-сервером состояния абонента (залогинен ли?)
###############################################################################################

# проверка текущего состояния.
$url = $_SERVER['REQUEST_URI'];// ?ip=2121&camera=cam45
$userip=$_GET['ip'];// юзер-ip передано нам в строке url стрим-сервером
$usercam=htmlspecialchars($_GET['camera']);
if (stristr($usercam,"archive"))
	{//Смотрят записи
	$viewmode="archive";
	$webcam = explode("-", $usercam);
	$usercam=$webcam[0];// так что $usercam - это название камеры и в случае архива
	}

@require_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");

$prov=@mysql_query("SELECT `action`,`userid`,`classroomid`,`camera` FROM `ovzor-log` WHERE `ip`='$userip' ORDER BY `date` DESC LIMIT 0,1");
$lastaction=@mysql_fetch_array($prov);
if ($lastaction[action]=="startshowcam" or $lastaction[action]=="startshow" or $lastaction[action]=="inprogress" or $lastaction[action]=="enter" or $lastaction[action]=="stopshow" or stristr($lastaction[action],"Paid"))
	{# Валидно, юзер залогинен и смотрит видео
	if ($lastaction[action]!=="startshow" and $lastaction[action]!=="startshowcam" and $lastaction[action]!=="inprogress")
		{$messagetolog="startshow";// Начало отчёта по баблу
		}
	else{
		$messagetolog="startshowcam";// Просто перешли на другую камеру
		}
	$userid=$lastaction[userid];
	echo "good";// разрешили стрим-серверу отдать видео
	@mysql_query("INSERT INTO `ovzor-log` (`ip`, `userid`, `classroomid`, `camera`,`date`, `action`) 
	VALUES ('$userip', '$userid', '0','$usercam', CURRENT_TIMESTAMP, '$messagetolog');"); // записали действие в лог
	}
else{// Не валидно - нет ip в табличке log с записями просмотра
	$messagetolog="user_is_not_found";
	$userid="0";
	echo "bad";
	// Если badpost много - написать что спамят
/*	$secondprov=@mysql_query("SELECT count(`action`) as spamcheck FROM `ovzor-log` WHERE `action`='badpost' and `date` < NOW() -  INTERVAL '5' MINUTE");
	$spamstat=@mysql_fetch_assoc($secondprov);
	if ($spamstat[spamcheck]>50)
		{// Нас спамят
		$subject="Спам на сайте";
		$from="Администрация сайта";
		$header="Content-type: text/html;  charset=utf-8\n";
		$header.="From: ".$from." www.ovzor.ru <ovzor@ovzor.ru>\n";
		$header.="Subject: ".$subject."\n";
		$header.="Content-type: text/html; charset=cp1251";
		$messagetoadmin="Большое количество спам-сообщений (например, IP=".$userip.") на iah.php (скрипт проверки статуса абона)";
		@ mail("support@ovzor.ru", $subject, $messagetoadmin, $header);
		$messagetolog="spam_mailed";
		}; */
	}
//@mysql_query("INSERT INTO `ovzor-log` (`ip`, `userid`, `classroomid`, `camera`,`date`, `action`) 
//	VALUES ('$userip', '$userid', '0','$usercam', CURRENT_TIMESTAMP, '$messagetolog');"); // записали действие в лог
?>