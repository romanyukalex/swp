<? //insert_module("sms_smscru","WIFI_RTK","79036766552","Тест test","0");

/*
echo "Всего сообщений - ".count($sitemessage)." в компании ".$_SESSION['site_company_id']."<br><br>";
foreach($sitemessage as $mess){
	echo "Сообщений:".count($mess)."<br><br>";
	var_dump($mess);echo "<br><br><br><br><br><br>";
}


echo "Всего сообщений - ".count($sitemessage)." в компании ".$_SESSION['site_company_id']."<br><br>";
foreach($sitemessage as $mess){
	echo "Сообщений:".count($mess)."<br><br>";
	var_dump($mess);echo "<br><br><br><br><br><br>";
}

echo "Settings<br>";
echo $sitedomainname;
*/


 
 global $rad_db_ad,$rad_pass_mode,$rad_pass_len,$rad_bras_ad,$wifi_access_mode,$wifi_access_vendor,$allot_wsdl_path,$rad_def_sp;		
	
# Параметры для подключения к БД freeradius
$rad_db_ad_data=explode("/",$rad_db_ad);			

$dbconnconnect1=mysql_connect($rad_db_ad_data[0],$rad_db_ad_data[1],$rad_db_ad_data[2]);
if($dbconnconnect1){#Подключение есть
	$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Got radius DB connect");
	$dbsel=mysql_select_db($rad_db_ad_data[3],$dbconnconnect1);

	
//$user_del_req = mysql_query("DELETE FROM radcheck WHERE `username` = '79169639930'",$dbconnconnect1);
//$user_del_req = mysql_query("DELETE FROM radcheck WHERE `username` = '79265033081'",$dbconnconnect1);
//$user_del_req = mysql_query("DELETE FROM radcheck WHERE `username` = '79031485697'",$dbconnconnect1);
//$user_del_req = mysql_query("DELETE FROM radcheck WHERE `username` = '79036766552'",$dbconnconnect1);

	$userreq=mysql_query("SELECT * FROM radcheck WHERE 1;",$dbconnconnect1);

	echo "ВСЕ ПОЛЬЗОВАТЕЛИ В БД radius<br><br>";
	while($users=mysql_fetch_array($userreq)){
		echo $users['username']."  ".$users['value']."<br>";

	}
}
?>