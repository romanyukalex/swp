<?php  session_start();
###############################################################################################
#Скрипт для проверки состояния абонента (он-лайн?) и выдачи ему обновления по минутам записей
###############################################################################################

# проверка текущего состояния.
$url = $_SERVER['REQUEST_URI'];
require_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/vzor/IPreal.php");
$userip=$ip;
$prov=@mysql_query("SELECT `action`,`userid`,`classroomid`,`camera`,`date` FROM `ovzor-log` WHERE `ip`='$userip' ORDER BY `date` DESC LIMIT 0,1");
$lastaction=@mysql_fetch_array($prov);
if ($lastaction[action]=="startshowcam" or $lastaction[action]=="startshow" or $lastaction[action]=="inprogress" or $lastaction[action]=="enter" or strstr("$lastaction[action]","Paid"))
	{# Валидно, юзер залогинен и смотрит видео
	if ($lastaction[action]=="enter" or strstr("$lastaction[action]","Paid")){die();}
	$messagetolog="inprogress";
	$userid=$lastaction[userid];
	$webcam[1]=$lastaction[camera];
	if ($lastaction[action]=="inprogress")
		{mysql_query("UPDATE `ovzor-log` SET `date` =  NOW() WHERE `ip` = '$userip' AND `action` = 'inprogress' AND `date`='$lastaction[date]';");
		}
	else{ @mysql_query("INSERT INTO `ovzor-log` (`ip`, `userid`, `classroomid`, `date`, `action`) 
		VALUES ('$userip', '$userid', '$webcam[1]', CURRENT_TIMESTAMP, '$messagetolog');");
		} // записали действие в лог
	# Парсим строку
	$cryteria = explode("%", $url);
	$cameraname=$cryteria[1];
	# Получаем ip cтримсервера
	$camerainfo=mysql_fetch_array(mysql_query("SELECT `forepostip` FROM `ovzor-classroom` WHERE `cameraname` = '$cameraname'"));
	$forepostip=$camerainfo[forepostip];
	# запрашиваемый день
	$day="$cryteria[2]";
	# Открываем сокет
	$fp = fsockopen($forepostip, 8082, $errno, $errstr, 30);
	if($fp) 
		{# Формируем запрос в открытый сокет
		$request = "GET /registrator/$cameraname/$day HTTP/1.1\r\n";
		$request .= "Host: $forepostip\r\n";
		$request .= "Connection: Close\r\n\r\n";
		# Отправляем request в сокет
		fwrite($fp, $request);
		#Убираем 3 строки заголовка http ответа (200 ОК)
		fgets($fp, 1024);fgets($fp, 1024);fgets($fp, 1024);
		# Выдаем весь JSON в ответ
		while(!feof($fp)) echo fgets($fp, 1024);
		# Закрываем всё
		fclose($fp);
		}
	else echo "Error: ".$errstr." (#".$errno.")";
	die();
	}
elseif($lastaction[action]=="badpost")
	{// Не первый badpost, нас спамит, отправляем мейл админу
	$subject="Спам на сайте";
	$from="Администрация сайта";
	$header="Content-type: text/html;  charset=utf-8\n";
	$header.="From: ".$from." www.ovzor.ru <ovzor@ovzor.ru>\n";
	$header.="Subject: ".$subject."\n";
	$header.="Content-type: text/html; charset=cp1251";
	$messagetoadmin="IP: ".$userip." спамит на iah.php (скрипт проверки статуса абона)";
	@ mail("support@ovzor.ru", $subject, $messagetoadmin, $header);
	$messagetolog="spam_mailed";
	$userid="0";
	$webcam[1]="0";
	}
elseif($lastaction[action]=="spam_mailed")
	{die();
	}
else{// Не валидно - нет ip в табличке log с записями просмотра
	echo "ne valid";
	$messagetolog="badpost";
	$userid="0";
	$webcam[1]="0";
	// Если badpost много - написать что спамят
	$secondprov=@mysql_query("SELECT count(`action`) as spamcheck FROM `ovzor-log` WHERE `action`='badpost' and `date` < NOW() -  INTERVAL '5' MINUTE");
	$spamstat=@mysql_fetch_assoc($secondprov);
	if ($spamstat[spamcheck]>50)
		{// Нас спамят
		$subject="Спам на сайте";
		$from="Администрация сайта";
		$header="Content-type: text/html;  charset=utf-8\n";
		$header.="From: ".$from." www.ovzor.ru <ovzor@ovzor.ru>\n";
		$header.="Subject: ".$subject."\n";
		$header.="Content-type: text/html; charset=cp1251";
		$messagetoadmin="Большое количество спам-сообщений (например, IP=".$userip.") на скрипт проверки статуса абона";
		@ mail("support@ovzor.ru", $subject, $messagetoadmin, $header);
		$messagetolog="spam_mailed";
		};
	}
@mysql_query("INSERT INTO `ovzor-log` (`ip`, `userid`, `classroomid`, `date`, `action`) 
	VALUES ('$userip', '$userid', '$webcam[1]', CURRENT_TIMESTAMP, '$messagetolog');"); // записали действие в лог
?>