<? 
/* Мониторинг серверов по SSH
Как снимать
На WEB:    tcpdump -i eth1 udp port 162 -w /home/teligent/public_html/snmpdump8.cap -vv -s 0 - снимать по порту 162
На prov: запускаешь tcpdump -i eth1 udp port 162 -w /snmpdump54.cap -vv -s 0 и во второй сессии /sbin/service karaf-service stop/start */
//@require("/home/teligent/public_html/hostnames.php");
//@require("/home/teligent/public_html/SNMP.php");
//date_default_timezone_set('UTC');


if($_REQUEST['mode']=="debug"){
	require($_SERVER["DOCUMENT_ROOT"]."/hostnames.php");
	require($_SERVER["DOCUMENT_ROOT"]."/SNMP.php");
	}
else{
	@require("/home/teligent/public_html/hostnames.php");
	@require("/home/teligent/public_html/SNMP.php");
	//date_default_timezone_set('UTC');
	}

$snmptrapip="192.168.33.17";
$community = 'public';
if($_REQUEST['mode']=="debug"){$file = "hostnames.php";}
else{$file = "/home/teligent/public_html/hostnames.php";}

$fp1 = fopen($file,"w");//очищаем файл
fwrite($fp1,"<? "."\r\n");

foreach ($ipaddr as $key => $ip) {
echo "Хост №".$key."  ";
# имя хоста и IP, которое будет записано в файл
$intofile = "$"."hostname[".$key."]=".'"'.$hostname[$key].'";'."\r\n"."$"."ipaddr[".$key."]=".'"'.$ip.'";'."\r\n";
# Откроем соккет
$fp = fsockopen($ip, '22', &$errno, &$errstr, 4 );
if (!$fp)
	{$newstatus="NOK";
	if($_REQUEST['mode']=="debug"){echo "$hostname[$key] $ip - NOK";}
	}
else{$newstatus="OK";
	fclose($fp);
	if($_REQUEST['mode']=="debug"){echo "$hostname[$key] $ip - OK";}
	}
if ($newstatus!==$status[$key])
	{// Статус изменился
	if($_REQUEST['mode']=="debug"){echo " - Меняем статус в файле и отправляем трап на $snmptrapip";}
	$status[$key]=$newstatus;
	if($_REQUEST['mode']=="debug"){echo " - Теперь статус в файле - $status[$key]<br>";}
	if ($newstatus=="NOK")
		{// Интерфейс упал
		$snmpmessage = "Host IP is down";
		$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1.2", 'value'=>2);// 2 - упал (raise)
		$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1001.1.1", 'value'=>2); // упал
		}
	else{// Интерфейс поднялся
		$snmpmessage = "Host is up";
		$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1.2", 'value'=>3);// 3 - почистился (clear)
		$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1001.1.1", 'value'=>1); // поднялся
		}
	// http://www.webnms.com/net-snmp/help/developing_management_applications/datatypes/textual_conventions/tcs_dateandtime.html   - про дату в DateAndTime 
	//2002-9-3,12:20:32.3

	$dateAndTime=dec2hex(floor(date("Y")/256)); 
	$dateAndTime.=dec2hex(date("Y")%256);
	$dateAndTime.=dec2hex(date("m"));
	$dateAndTime.=dec2hex(date("d"));
	$dateAndTime.=dec2hex(date("H"));
	$dateAndTime.=dec2hex(date("i"));
	$dateAndTime.=dec2hex(date("s"));
	$dateAndTime.=dec2hex(date("u")/100);
	
	if($_REQUEST['mode']=="debug"){echo "Дата в MIB - ".$dateAndTime;}
	$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1.3", 'value'=>$dateAndTime, 'type'=>'x'); // Дата
	$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1.4", 'value'=>$snmpmessage); // Месседж
	$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1.5", 'value'=>5); // северити. 5 - critical
	$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1001.1.2", 'value'=>$hostname[$key]); // хост
	# отправляем трап
	SNMP::trap($snmptrapip, $vars, $community);
	# Запись в лог
	// Сформировать строку для лога
	$actdate=date("Y-m-d H:i");
	$str01 = "$actdate $hostname[$key]($ipaddr[$key]): status changed to $status[$key]\r\n";
	// Открыть файл и дописать в него строку
	if($_REQUEST['mode']=="debug"){$log = fopen("servers_monitor.log","a+");}
	else{$log = fopen("/home/teligent/public_html/servers_monitor.log","a+");}
	
	if(!$log){
		if($_REQUEST['mode']=="debug"){echo "servers_monitor.log n/a";}
		}
	else{fwrite($log, $str01);}
	fclose($log);
	# Убиваем массив vars
	while ($vars){array_pop($vars);}
	}
else{
	if($_REQUEST['mode']=="debug"){echo " - Не меняем ничего<br>";}
	}
$intofile.= "$"."status[".$key."]=".'"'.$status[$key].'";'."\r\n"."\r\n"; // добавили текущее состояние для записи в файл
fwrite($fp1,$intofile);// Записали в файл текстик
} // foreach

fwrite($fp1,"?> "."\r\n");
fclose($fp1); //закончили работать с файлом

function strToHex($string)
{
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}
?>