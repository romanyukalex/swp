<?

# Активация IaaS через оркестратор HP
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


if($argv[2]){ // Передали и проект, и order_id
	insert_function("send_letter");
	$order_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-orders` o,`$tableprefix-users` u,`$companiesprefix-companies` comp, `$companiesprefix-product-variants` vars,`$companiesprefix-product` prod WHERE o.`order_id`='$argv[2]' and o.`user_id`=u.`userid` and comp.`company_id`=o.`client_id` and vars.`variant_id`=o.`product_variant_id` and vars.`product_id`=prod.`product_id` LIMIT 0,1;"));

	$act_string_arr=json_decode( $order_info['activation_string'], true);

	$balancerip=$act_string_arr["param"]["balancerip"];
	$balancerport=$act_string_arr["param"]["balancerport"];
	$basicauthuser=$act_string_arr["param"]["basicauthuser"];
	$basicauthpwd=$act_string_arr["param"]["basicauthpwd"];
	$HP_soap_id=$act_string_arr["param"]["soap_id"];
	$HP_soap_OS=$act_string_arr["param"]["os"];
	$HP_soap_cpu=$act_string_arr["param"]["cpu_count"];
	$HP_soap_cores=$act_string_arr["param"]["cores_per_socket"];
	$HP_soap_memory=$act_string_arr["param"]["memory"];
	$HP_soap_lt=$act_string_arr["param"]["vm_lifetime_hours"];
	
	
	$HP_soap_disp_name="Request from TS-Cloud IaaS";
	$HP_soap_VMname=$order_info['company_id']."-".$order_info['order_id']; // В одно слово, только буквы и знак -, не более 13 символов
	
	$vm_ip_req=mysql_query("SELECT * FROM `tscloud-iaas_ip` WHERE `leased_upto` < NOW() LIMIT 0,1");
	if(mysql_num_rows($vm_ip_req)>0){
		$vm_ip=mysql_fetch_array($vm_ip_req);
		
		# Блокируем IP от повторного заказа
		mysql_query("UPDATE  `$tableprefix-iaas_ip` SET  `leased_upto` =  '".date("Y-m-d H:i:s", time()+$HP_soap_lt*3600)."' WHERE `ip_id` ='".$vm_ip['ip_id']."';");
		
		# Запускаем первый запрос
		$xml_post="<ServiceRequest>
			<description>Automated request TS-Cloud for orderid=21123213</description>
			<name>Test Request n. 1</name>
			<displayName>".$HP_soap_disp_name."</displayName>
				<artifactContext>
					<id>8a5693ba532ffb9401533180489022cc</id>
				</artifactContext>
			<requestedAction>
				<name>ORDER</name>
				<property>
					<name>START_DATE</name>
						<values>
							<value>".date("Y-m-d\TH:i:s", time()-5*3600).".001+04:00</value>
						</values>
				</property>
				<property>
					<name>END_DATE</name>
						<values>
							<value>".date("Y-m-d\TH:i:s", time()+($HP_soap_lt-4)*3600).".001+04:00</value>
						</values>
				</property>
				<property>
					<name>SERVICE_NAME</name>
						<values>
							<value>$HP_soap_disp_name</value>
						</values>
				</property>
				<property>
					<name>SERVICE_DESCRIPTION</name>
						<values>
							<value>$HP_soap_disp_name</value>
						</values>
				</property>
				<property>
					<name>OPTION_MODEL</name>
					<values>
						<optionModel>
							<name>a1ff377a-a43c-4254-b6e3-822122eeb128</name>
							<optionSets>
								<name>initialOrderConfigurations</name>
								<options>
									<name>no_profile</name>
										<property>
											<name>$HP_soap_id;mem;</name>
											<values>
												<value>".($HP_soap_memory*1028)."</value>
											</values>
										</property>

										<property>
											<name>$HP_soap_id;cpu_count;</name>
											<values>
												<value>".$HP_soap_cpu."</value>
											</values>
										</property>
										
										<property>
											<name>$HP_soap_id;cores_per_socket;</name>
											<values>
												<value>".$HP_soap_cores."</value>
											</values>
										</property>
										
										<property>
											<name>$HP_soap_id;New_VM_Name;</name>
											<values>
												<value>$HP_soap_VMname</value>
											</values>
										</property>
										
										<property>
											<name>$HP_soap_id;opt;</name>
											<values>
												<value>".$HP_soap_OS."</value>
											</values>
										</property>
										
										<property>
											<name>$HP_soap_id;NewVMip;</name>
											<values>
												<value>".$vm_ip['ip']."</value>
											</values>
										</property>
										
								</options>
							</optionSets>
						</optionModel>
					</values>
				</property>
			</requestedAction>
		</ServiceRequest>
		";
		insert_function("collect_data");
		$data=collect_data2("https","POST",$balancerip,$balancerport,$basicauthuser,$basicauthpwd,false,"csa/rest/catalog/90d9650a36988e5d0136988f03ab000f/request?userIdentifier=BFA0DB53DA414B90E04059106D1A24B5",false,$xml_post);
		
		$xml1 = simplexml_load_string($data);

		# ID первого запроса
		$service_id=$xml1->id;
		$log->LogDebug("Request ID in HP orch is ".$service_id);
		sleep(10);
		
		
		# Получаем ID статуса подписки
		$data2=collect_data2("https","GET",$balancerip,$balancerport,$basicauthuser,$basicauthpwd,false,"/csa/rest/catalog/90d9650a36988e5d0136988f03ab000f/request/".$service_id."?userIdentifier=BFA0DB53DA414B90E04059106D1A24B5");

		$ddd=explode("<name>SUBSCRIPTION_ID</name>",$data2);
		$pos1=strpos($ddd[1], "<value>");
		$subscription_status_id=substr($ddd[1],$pos1+7,32);	 // ID статуса
		if(!$subscription_status_id){
			$log->LogDebug("Subscription status ID in HP orch is NOT FOUND. Script is stopped");
		}
		$log->LogDebug("Subscription status ID in HP orch is ".$subscription_status_id);
		
		# Запрашиваем по ID статуса его состояние раз в 30 секунд
		while($ddddddd[0]!=="ACTIVE"){
			$subscript_status_q=collect_data2("https","GET",$balancerip,$balancerport,$basicauthuser,$basicauthpwd,false,"csa/rest/catalog/90d9650a36988e5d0136988f03ab000f/subscription/".$subscription_status_id."?userIdentifier=BFA0DB53DA414B90E04059106D1A24B5");
			
			$dddd=explode("<subscriptionStatus>",$subscript_status_q);
			$ddddd=explode("</subscriptionStatus>",$dddd[1]);
			//echo "<textarea cols='100' rows='3'>".$ddddd[0]."</textarea>";
			$dddddd=explode("<name>",$ddddd[0]);
			$ddddddd=explode("</name>",$dddddd[1]);
			echo $ddddddd[0];
			$log->LogInfo("Current status of ".$subscription_status_id." is ".$ddddddd[0]);
			sleep(30);
		}
		# Вышли
		if($ddddddd[0]=="ACTIVE"){
			$log->LogInfo("VM created in HP orch with IP ".$vm_ip['ip']);
			
			
			
			# Переводим заказ в правильный статус
			mysql_query("UPDATE  `$tableprefix-orders` SET  `status` =  'resolved' WHERE `order_id` ='$argv[2]';");
			# Добавляем подписку
			mysql_query("INSERT INTO  `$companiesprefix-subscriptions` (
	`subscription_id` ,`user_id` ,`client_id` ,`subscription_group_id` ,`product_variant_id` ,`status` ,`creations_ts` , `last_status_change_ts` ,`charging_aligment` ,`charging_period_days` ,`charging_period_months` ,`is_charging_prepaid` ,`price` , `currency` ,`script`)
	VALUES (NULL ,  '".$order_info['user_id']."',  '".$order_info['client_id']."', NULL ,  '".$order_info['product_variant_id']."',  'active',  '".$order_info['creations_ts']."', CURRENT_TIMESTAMP ,  '".$order_info['charging_aligment']."', '".$order_info['charging_period_days']."' , '".$order_info['charging_period_months']."' , '".$order_info['is_charging_prepaid']."' ,  '".$order_info['price']."',  '".$order_info['currency']."', NULL);");

			# Отправляем письмо пользователю
			
			$subject="Ваша заявка на ".$sitedomainname." исполнена";				
			$message="Здравствуйте,".$order_info['fullname']."!<br><br>На портале ".$sitedomainname." была исполнена заявка номер ".$order_info['company_id']."-".$order_info['order_id']." на продукт:<br>".$order_info['product_full_title_ru']."<br>Вариант продукта:".$order_info['description_ru']."<br><br>";
			$message.="Доступ к услуге:<br>Логин - user1<br>Пароль - Technoserv123!<br>Сервер - ".$vm_ip['ip']."<br><br>";
			$message.="<br><br>С наилучшими пожеланиями.<br><b>Администрация сайта ".$sitedomainname;
			sendletter($order_info['contactmail'],$subject,$message);
		} else { # Не удачная попытка заказа услуги, странный случай, тк процесс должен висеть до статуса Active
			# Разблокируем IP для повторного заказа
			mysql_query("UPDATE  `$tableprefix-iaas_ip` SET  `leased_upto` =  '".date("Y-m-d H:i:s", time())."' WHERE `ip_id` ='".$vm_ip['ip_id']."';");
			$log->LogError("VM was not created in HP Orch. IP ".$vm_ip['ip']." is unblocked");
		}
	} else {// Нет свободных IP
		# Отправляем письмо админу
			
			$subject="Заявка на ".$sitedomainname." не может быть исполнена";				
			$message="Здравствуйте<br>".$order_info['fullname']." на портале ".$sitedomainname." была исполнена заявка номер ".$order_info['company_id']."-".$order_info['order_id']." на продукт:<br>".$order_info['product_full_title_ru']."<br>Вариант продукта:".$order_info['description_ru']."<br><br>";
			$message.="<b>Доступ к услуге не может быть предоставлен из-за нехватки IP-адресов</b>"."<br><br>";
			$message.="<br><br>С наилучшими пожеланиями.<br><b>Администрация сайта ".$sitedomainname;
			sendletter("cloud@technoserv.com",$subject,$message);
	}

} else $log->LogInfo("No order_id in console command");