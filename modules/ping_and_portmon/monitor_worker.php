<?php

if ($argc != 6) { # Не хватает аргументов
    die(PHP_EOL . 'Use: php '.(__FILE__).' project ip_addr port mon_type mon_period' . PHP_EOL);
} elseif (extension_loaded('pcntl')==FALSE){# Модуль pcntl не подключен - завершаем вызов с соотв сообщением
	die(PHP_EOL . "Please, install pcntl module via 'sudo yum install php php-cli' command" . PHP_EOL);
}
$nitka=1;
//На вход подаем: project, ip_addr, port, mon_type, mon_period
$project     = $argv[1];
$ip_addr = $argv[2];
$port = $argv[3];
$mon_type = $argv[4];
$mon_period = $argv[5];


$breakthisfile = Explode('/', $_SERVER["SCRIPT_NAME"]);
unset ($breakthisfile[count($breakthisfile)-1]); //Удалили название скрипта
$this_path=implode('/', $breakthisfile); 
if($breakthisfile[count($breakthisfile)-1]!=="modules")unset ($breakthisfile[count($breakthisfile)-1]); //Мы все еще в глубине файловой системы, удаляем папку с модулем
unset ($breakthisfile[count($breakthisfile)-1]); //Удаляем /modules
$_SERVER["DOCUMENT_ROOT"]=implode('/', $breakthisfile); // Домашняя директория всего сайта
require($_SERVER["DOCUMENT_ROOT"]."/core/start_platform_scripts_cron.php");
require($this_path."/config.php");//Конфиг модуля

declare(ticks = 1); # Нужно для сигналов демона

$stop = FALSE;


function sig_handler($signo) { // Функция перехватывающая сигналы
	global $stop;
	switch ($signo) 
	{
		case SIGTERM:
			echo "Закрываем какие-нибудь соединения с базой\n";
			echo "Для примера, ждём 5 секунд, и устанавливаем флаг завершения работы\n";
			sleep(5);
			$stop = TRUE;
			echo "Время прошло\n";
			break;
		case SIGUSR1:
			echo "Привет, ты вызвал пользовательский сигнал\n";
			break;
		default:
			// Ловим все остальные сигналы
	}
}

// Регистрируем сигналы
pcntl_signal(SIGTERM, "sig_handler");
pcntl_signal(SIGUSR1, "sig_handler");



$pid = pcntl_fork();// Форкаем процесс

if ($pid == -1) { // Ошибка 
	die('could not fork'.PHP_EOL);
}
else if ($pid) { // Родительский процесс, убиваем
	die('die parent process'.PHP_EOL);
}
else {# Новый процесс
	//$log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | This is daemon mode"); 
	require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php"); //Переподключаем базу, глючит PHP.$dbconnconnect видит, но не посылает запросы 
	
	# Имя файла с PID нашего процесса
	define(PIDFILE_NAME, $_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/".$mon_type. str_replace ('.' , '' ,$ip_addr) . $port. "every".$mon_period. '.pid');


	if (is_readable(PIDFILE_NAME)) { #Файл найден
		$pid = (int)file_get_contents(PIDFILE_NAME);

		if ($pid > 0 && posix_kill($pid, 0)) {# Такой демон найден и запущен
			$log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | New worker NOT started in daemon mode because process is already running with PID =".$pid);
			exit;
		}

		if (!unlink(PIDFILE_NAME)) {# Файл найден, но демон не найден. Стираем файл с PID
			$log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | Attention. PID-file delete can NOT be erased");
			exit;
		}
	}

	
	$pid = posix_getpid(); # PID дочки

	if (!file_put_contents(PIDFILE_NAME, $pid)) { # Пишем PID в файл
		$log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | Attention. PID-file can NOT be updated");
		exit;
	}
	
	$log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | New worker started in daemon mode (PID = ".$pid.") with params: ".implode(',',$argv));
	
	include($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/Ping.php");//Класс мониторинга
	$ping = new Ping($ip_addr);
	
	$newhost=$ping->setHost($ip_addr);
	$newhost=$ping->setPort($port);

	$node_info_qt="SELECT * FROM `$tableprefix-monitor-nodes` WHERE `ipaddr`='$ip_addr' and `mon_type`='$mon_type' and `mon_period`='$mon_period' and `port`";
	if($port=="0") $node_info_qt.=" is NULL";
	else $node_info_qt.="='$port'";
	$node_info_qt.=" LIMIT 0,1;";
	$node_info_q=mysql_query($node_info_qt);
	$node_info=mysql_fetch_array($node_info_q);//Инфо узла мониторинга
	$curstatus=$node_info['cur_status'];
	
	
	if($curstatus) $log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | Current status of ".$ip_addr.":".$port." before checking was ".$curstatus);
	
	$log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | Start to do ".$mon_type." ever ".$mon_period." microsec");
	
	if($mon_type){$mon_type="exec";}
	while( ! $stop ) { //запускаем главный цикл
		$latency = $ping->ping($mon_type);
		
		if ($latency !== false) {# OK
			$newstatus="alive";
		}
		else { #NOK
			$newstatus="dead";
		}
		if ($newstatus!==$curstatus){// Статус изменился
			
			$log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | Node ".$ping->getHost()." new status is ".$newstatus);
			#Cur_status update
			$cst_upd_qt="UPDATE `$tableprefix-monitor-nodes` SET `cur_status` = '$newstatus' WHERE `node_id` = '".$node_info['node_id']."';";
			$cst_upd_q=mysql_query($cst_upd_qt);
			if($cst_upd_q) $log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | Node (".$ping->getHost().") new current status was updated in DB");
			else $log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | Node (".$ping->getHost().") new current status was NOT updated in DB");
			#Event history
			$evhist_q=mysql_query("INSERT INTO `$tableprefix-monitor-events` (`event_id` ,`node_id` ,`event` ,`event_date` ,`comment` ) VALUES 
			(NULL , '".$node_info['node_id']."', '$newstatus', CURRENT_TIMESTAMP , NULL );");
			if($evhist_q) $log->LogDebug(basename(__FILE__)." | ".(__LINE__)." |  Event was inserted into DB. Node is ".$ping->getHost());
			else $log->LogDebug(basename(__FILE__)." | ".(__LINE__)." | Event was NOT inserted into DB. Node is ".$ping->getHost());
		}
		$curstatus=$newstatus;
		usleep($mon_period);
	}
}
// Отцепляемся от терминала
posix_setsid();