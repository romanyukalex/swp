<? #### Скрипт,меняющий статусы платежей Хронопэй и стирающий абонентов с WiFi Tariff Free (WTF) ####

$_SERVER["DOCUMENT_ROOT"]="/home/teligent/public_html";
include_once("/home/teligent/public_html/system-param.php");
include_once("/home/teligent/public_html/process_user_data.php");
//include_once("/home/teligent/public_html/core/db/dbconn-read.php");
#########################################################################################################
### Скрипт, меняющий строки в БД, дата которых более получаса и не получено подтверждение от Хронопэя ###
#########################################################################################################
$dbcleantime=60*substr($dbcleantime,0,5);
$salt=rand(1,10000);
mysql_query("UPDATE `chronopays` SET `status`='8' WHERE `status`='1' and (unix_timestamp(now()) - unix_timestamp(`lastupdate`))>$dbcleantime --$salt;");
mysql_query("DELETE FROM `chronopays` WHERE (`status`='8' or `status`='9') and (unix_timestamp(now()) - unix_timestamp(`lastupdate`))>5356800 --$salt;"); // Стираем все строки, что более 62 дней совсем

#########################################
### Скрипт, стирающий абонентов с WTF ###
#########################################
$WTFcleantime=60*$WTFcleantime;
$users=mysql_query("SELECT `Login` FROM `wifi-WTFusers` WHERE (unix_timestamp(now()) - unix_timestamp(`EVENTDATE `))>$WTFcleantime --$salt;");
while($user=mysql_fetch_array($users)){
	$login=$user['Login'];
	# Удаляем пользователя (SOAP) ####
	$fp = fsockopen($balancerip, $balancersoapport, $errno, $errstr, 30);
	if($fp){if ($mode=="debug"){$showmessage.="<br>Сокет ".$balancerip." ".$balancersoapport." открыт";}
		
		$request = 'POST /billing HTTP/1.1
Content-Type: text/xml;charset=utf-8
SOAPAction: 
Host: '.$balancerip.':'.$balancersoapport.'
Content-Length: 302
	
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:prov="http://ru.mts.esb.provision/schema/provisionWifi"><soapenv:Header/><soapenv:Body><prov:deleteSubscriberRequest><prov:msisdn>'.$login.'</prov:msisdn></prov:deleteSubscriberRequest></soapenv:Body></soapenv:Envelope>';
	
		if ($mode=="debug"){$showmessage.="<br>Запрос:".$request."<br>";}
		# Отправляем request в сокет
		fwrite($fp, $request);
		while(!feof($fp)) 
			{
			$answer1 .=fgets($fp, 1024); 
			}
		# Закрываем всё
		fclose($fp);
		if ($mode=="debug"){$showmessage.="<br>Ответ:".$answer1."<br>";}
		if (strstr($answer1,"HTTP/1.1 200")){// Запрос на создание юзера успешно обработан платформой
			if ($mode=="debug"){$showmessage.="<br>Пользователь ".$login." удален";}
			mysql_query("UPDATE `wifi-WTFusers` SET `status`='2' WHERE `Login`='79153964887';");
		}
	}
}
?>
