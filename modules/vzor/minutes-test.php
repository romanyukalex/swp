<?php 
###############################################################################################
#Скрипт для проверки состояния абонента (он-лайн?) и выдачи ему обновления по минутам записей
###############################################################################################

# проверка текущего состояния.
$url = $_SERVER['REQUEST_URI'];
$userip=$_SERVER['REMOTE_ADDR'];
@require_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	# Парсим строку
	$cryteria = explode("%", $url);
	$cameraname=$cryteria[1];
	# Получаем ip cтримсервера
	$camerainfo=mysql_fetch_array(mysql_query("SELECT `forepostip` FROM `ovzor-classroom` WHERE `cameraname` = '$cameraname'"));
	$forepostip=$camerainfo[forepostip];
//	echo $forepostip;
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

?>