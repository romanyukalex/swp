<?

# Активация BMC Remedy
$nitka=1;
$breakthisfile = Explode('/', $_SERVER["SCRIPT_NAME"]);
unset ($breakthisfile[count($breakthisfile)-1]); //Удалили название скрипта
$this_path=implode('/', $breakthisfile);
if($breakthisfile[count($breakthisfile)-3]=="project"){
	unset ($breakthisfile[count($breakthisfile)-1]);
	unset ($breakthisfile[count($breakthisfile)-1]);
	unset ($breakthisfile[count($breakthisfile)-1]);
}

$_SERVER["DOCUMENT_ROOT"]=implode('/', $breakthisfile); // Домашняя директория всего сайта

require($_SERVER["DOCUMENT_ROOT"]."/core/start_platform_scripts_cron.php");


if($argv[2]){
	insert_function("send_letter");
	$order_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-orders` o,`$tableprefix-users` u,`$companiesprefix-companies` comp, `$companiesprefix-product-variants` vars,`$companiesprefix-product` prod WHERE o.`order_id`='$argv[2]' and o.`user_id`=u.`userid` and comp.`company_id`=o.`client_id` and vars.`variant_id`=o.`product_variant_id` and vars.`product_id`=prod.`product_id` LIMIT 0,1;"));

	$act_string_arr=json_decode( $order_info['activation_string'], true);


	$balancerip=$act_string_arr["param"]["balancerip"];
	$balancerport=$act_string_arr["param"]["balancerport"];
	$soap_path=$act_string_arr["param"]["soap_path"];
	echo $balancerport;


$soap_req='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SAS_CompanyCreateWS">
   <soapenv:Header>
      <urn:AuthenticationInfo>
         <urn:userName>appadmin</urn:userName>
         <urn:password>q1</urn:password>
         <!--Optional:-->
         <urn:authentication>?</urn:authentication>
         <!--Optional:-->
         <urn:locale>?</urn:locale>
         <!--Optional:-->
         <urn:timeZone>?</urn:timeZone>
      </urn:AuthenticationInfo>
   </soapenv:Header>
   <soapenv:Body>
      <urn:Create>
         <!--Optional:-->
         <urn:CompanyName>'.$order_info['company_full_name'].'</urn:CompanyName>
      </urn:Create>
   </soapenv:Body>
</soapenv:Envelope>';
				
				
				
				
$request = 'POST '.$soap_path.' HTTP/1.1
Host: '.$balancerip.'
Connection: Close
User-Agent: PHP-SOAP/5.3.3
Content-Type: text/xml; charset=utf-8
SOAPAction: "urn:SAS_CompanyCreateWS/Create"
Content-Length: '.strlen($soap_req)."\r\n\r\n".$soap_req;

	echo "<br>Запрос:".$request."\r\n";
	# Отправляем request в сокет

	$fp = fsockopen($balancerip, $balancerport, $errno, $errstr, 30);
	fwrite($fp, $request);
	while(!feof($fp))
		{
		$answer1 .=fgets($fp, 1024);
		}
	# Закрываем всё
	fclose($fp);
	
	echo "Ответ:".$answer1."\r\n";
	$log->LogDebug("SOAP query (for company creation) was sent. Answer is: ".$answer1);

	$answer_xml1=mb_strstr($answer1,"<?xml ");
	$answer_xml=substr($answer_xml1,0,strripos($answer_xml1, "</soapenv:Envelope>")+19);


	//echo "XML после обработки:<textarea cols='100' rows='10'>".$answer_xml."</textarea><br>";
	insert_function("isValidXml");

	if(isValidXml($answer_xml)) {//прим. объект не создавался почему то

		$p = xml_parser_create();
		xml_parse_into_struct($p, $answer_xml, $vals, $index);
		xml_parser_free($p);


		$BMC_admin_login=$vals[3]["value"];
		$BMC_admin_pass=$vals[5]["value"];
		if($BMC_admin_login and $BMC_admin_pass){
			$log->LogInfo("Company created in BMC. Admin - ".$BMC_admin_login." Pass - ".$BMC_admin_pass);
			
			# Переводим заказ в правильный статус
			mysql_query("UPDATE  `$tableprefix-orders` SET  `status` =  'resolved' WHERE `order_id` ='$argv[2]';");
			# Добавляем подписку
			mysql_query("INSERT INTO  `$companiesprefix-subscriptions` (
`subscription_id` ,`user_id` ,`client_id` ,`subscription_group_id` ,`product_variant_id` ,`status` ,`creations_ts` , `last_status_change_ts` ,`charging_aligment` ,`charging_period_days` ,`charging_period_months` ,`is_charging_prepaid` ,`price` , `currency` ,`script`)
VALUES (NULL ,  '".$order_info['user_id']."',  '".$order_info['client_id']."', NULL ,  '".$order_info['product_variant_id']."',  'active',  '".$order_info['creations_ts']."', CURRENT_TIMESTAMP ,  '".$order_info['charging_aligment']."', '".$order_info['charging_period_days']."' , '".$order_info['charging_period_months']."' , '".$order_info['is_charging_prepaid']."' ,  '".$order_info['price']."',  '".$order_info['currency']."', NULL);");

			# Отправляем письмо пользователю
			
			$subject="Ваша заявка на ".$sitedomainname." исполнена";				
			$message="Здравствуйте,".$order_info['fullname']."!<br><br>На портале ".$sitedomainname." была исполнена заявка номер ".$order_info['company_id']."-".$order_info['order_id']." на продукт:<br>".$order_info['product_full_title_ru']."<br>Вариант продукта:".$order_info['description_ru']."<br><br>";
			$message.="Доступ к услуге:<br>Логин - ".$BMC_admin_login."<br>Пароль - ".$BMC_admin_pass."<br>Ссылка для входа в систему - http://".$balancerip."/arsys/<br>При первом входе необходимо сменить пароль.<br><br>";
			$message.="<br><br>С наилучшими пожеланиями.<br><b>Администрация сайта ".$sitedomainname;
			sendletter($order_info['contactmail'],$subject,$message);
		} else {
			$answer_status_code=substr($answer1,9,3);
			$log->LogError("Company was not created in BMC Remedy. Answer was - ".$answer_status_code);
		}
	} else {
		# Что был за ответ
		$answer_status_code=substr($answer1,9,3);
		if($answer_status_code=="200"){# Просто невалидный XML в 200ОК
			$log->LogError("An answer can not be parsed like XML. Company was not created in BMC Remedy");
		} else {
			$log->LogError("An answer was ".$answer_status_code);
		}
	}

} else $log->LogInfo("No order_id in console command");