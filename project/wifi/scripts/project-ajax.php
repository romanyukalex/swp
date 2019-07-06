<?php
 /***********************************************************************
  * Snippet Name : Project ajax scripts		 					 		*
  * Scripted By  : RomanyukAlex		           					 		*
  * Website      : http://popwebstudio.ru	   					 		*
  * Email        : admin@popwebstudio.ru     					 		*
  * License      : GPL (General Public License)					 		*
  * Purpose 	 : some ajax functions							 		*
  * Access		 : 														*
  *  ajaxreq(some_id1,some_id2,action,answer_place,"project_script");	*
  **********************************************************************/
 $log->LogInfo(basename (__FILE__)." | ".(__LINE__)." | Got ".(__FILE__));
if ($nitka=="1"){
	$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Got action equal ".$_REQUEST['action']);
	global $rad_db_ad,$rad_pass_mode,$rad_pass_len,$wifi_access_mode,$rad_bras_ad,$wifi_access_vendor,$allot_wsdl_path,$rad_def_sp,$ip;
	
	if($_REQUEST['action']=="register"){
		
		//При нажатии на “register” портал проверяет корректность формата ввода,  нет ли данного username в базе, пустой username и т.п. Если всё корректно, то генерирует пароль, заносит абонента в DB, создаёт его на SMP, отсылает пароль по SMS.
	
		$new_customer_phone=process_data($_REQUEST['new_customer_phone'],15);
		if($new_customer_phone){# Есть логин
			
			/* Здесь сделать выбор, как проверять наличие юзера в радиус сервере, по radius, или по БД freeradius
			
			Если по радиус:
			
			if(extension_loaded('radius')) {
				#Что то типа:
				$radius = radius_auth_open();
				radius_add_server($radius, $ip_address, $port, $shared_secret, 5, 3);
				radius_create_request($radius, RADIUS_ACCESS_REQUEST);
				radius_put_attr($radius, RADIUS_USER_NAME, $username);
				radius_put_attr($radius, RADIUS_USER_PASSWORD, $password);

				$result = radius_send_request($radius);

				switch ($result) {
				case RADIUS_ACCESS_ACCEPT:
				  // An Access-Accept response to an Access-Request indicating that the RADIUS server authenticated the user successfully.
				  echo 'Authentication successful';
				  break;
				case RADIUS_ACCESS_REJECT:
				  // An Access-Reject response to an Access-Request indicating that the RADIUS server could not authenticate the user.
				  echo 'Authentication failed';
				  break;
				case RADIUS_ACCESS_CHALLENGE:
				  // An Access-Challenge response to an Access-Request indicating that the RADIUS server requires further information in another Access-Request before authenticating the user.
				  echo 'Challenge required';
				  break;
				default:
				  die('A RADIUS error has occurred: ' . radius_strerror($radius));
				}
			} else echo "Не установлен radius-модуль, используй готовый класс radius";
			Если по БД freeradius*/
			
			
			# Подключаем DB freeradius
			
			$rad_db_ad_data=explode("/",$rad_db_ad);			
			
			$dbconnconnect1=mysql_connect($rad_db_ad_data[0],$rad_db_ad_data[1],$rad_db_ad_data[2]);
			if($dbconnconnect1){#Подключение есть
				$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Got radius DB connect");
				$dbsel=mysql_select_db($rad_db_ad_data[3],$dbconnconnect1);
				
				$userreq=mysql_fetch_array(mysql_query("SELECT * FROM radcheck WHERE `username` = '$new_customer_phone'",$dbconnconnect1));

				if(!$userreq['username']){ # Пользователь не найден в БД freeradius
					$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | User with login $new_customer_phone was not found in freeradius DB");
					# Генерируем пароль
					insert_function("abracadabra");
					if($rad_pass_mode=="Только цифры")	$newpwd=abracadabra($rad_pass_len,"digits");
					elseif($rad_pass_mode=="Только буквы")	$newpwd=abracadabra($rad_pass_len,"characters");
					elseif($rad_pass_mode=="Смесь букв и цифр") $newpwd=abracadabra($rad_pass_len,"mix");
					# Пишем пользователя в БД radius
					$user_add_req = mysql_query("INSERT INTO radcheck (UserName, Attribute, Value) VALUES ('$new_customer_phone', 'Password', '$newpwd')",$dbconnconnect1);
					# Пишем связку пользователя и тарифа в БД SWP
					require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
					$tariff_add_req = mysql_query("INSERT INTO `$tableprefix-wifi-user_tariff` 
					(`raw_id`, `userid`, `tariff_code`) VALUES (NULL, '$new_customer_phone', '$rad_def_sp');");
					if($wifi_access_vendor=="Allot"){
						
						$smp_client = new SoapClient( "$allot_wsdl_path",array("trace" => 1) );
						# Проверяем, есть ли пользователь в БД Allot (дописать)
						#Пользователь есть
						//$smp_request = array('in0' => "$new_customer_phone"); - не работает
						//$subscriber_info=$smp_client->getSubscriber($smp_request);//echo $subscriber_info;
						# Добавляем пользователя на SMP
						$smp_request = array('in0' => array(	'admin' => 1, 'basicGroupName' => $rad_def_sp, 'currentGroupName' => $rad_def_sp,'extid' => $new_customer_phone,),);
						$smp_client->addSubscriber($smp_request);
					}
					
					#Отсылаем пароль по SMS
					insert_module("sms_smscru","WIFI service","$new_customer_phone","Вы успешно зарегистрировались в WiFi-сети. Ваш пароль - $newpwd","0");
					
					# Отвечаем
					$aRes = array('status' => 'ok', 'message' => '<span style="color:green">'.$sitemessage["registration_form"]["activation_complete"].'</span>');
					echo json_encode($aRes);
					
				} else {//"Пользователь с указанным телефоном уже существует";
					$aRes = array('status' => 'nok', 'message' => '<span style="color:red">'.$sitemessage["registration_form"]["user_already_exists"].'</span>');
					echo json_encode($aRes);
					$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | User with login $new_customer_phone already exists in freeradius DB");
				}
			} else {$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Can't create radius DB connect");
				echo $sitemessage["registration_form"]["user_cant_be_added"];
			}
		} else {$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | There is no customer login in ".$_REQUEST['action']." request");
			echo $sitemessage["registration_form"]["user_cant_be_added"];//Не удалось добавить пользователя (нет логина)
		}			
	}
	
	
	elseif ($_REQUEST['action']=="access_grant"){ # Дать доступ юзеру
		
		# Проверяем АД
		$customer_login=process_data($_REQUEST['username'],15);
		$customer_pass=process_data($_REQUEST['password'],($rad_pass_len+15));
		# Параметры для подключения к БД freeradius
		$rad_db_ad_data=explode("/",$rad_db_ad);			
		
		$dbconnconnect1=mysql_connect($rad_db_ad_data[0],$rad_db_ad_data[1],$rad_db_ad_data[2]);
		if($dbconnconnect1){#Подключение есть
			$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Got radius DB connect");
			$dbsel=mysql_select_db($rad_db_ad_data[3],$dbconnconnect1);
		
			$userreq=mysql_fetch_array(mysql_query("SELECT * FROM radcheck WHERE `username` = '$customer_login' and `attribute`='Password' and `op`='==' and `value`='$customer_pass'",$dbconnconnect1));

			
			
			if(!$userreq['username']){ # Пользователь не найден в БД freeradius
				$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | User with login $customer_login was not found in freeradius DB");
				
				$aRes = array('status' => 'nok', 'message' => '<span style="color:red">'.$sitemessage["system"]["LoginPass_is_wrong"].'</span>');

				echo json_encode($aRes);
				
				
			} else {# Пользователь с указанным телефоном найден в БД freeradius
				$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | User with login $customer_login was found in freeradius DB");
				
				# Открываем доступ этому юзеру
				include($_SERVER["DOCUMENT_ROOT"]."/core/IPreal.php");//Определяем IP пользователя
				
				if($wifi_access_mode=="Allot_soap_api"){ // Открыть по SOAP
				
					# Узнаем тариф пользователя
					require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
					$cust_tariff_code=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-wifi-user_tariff` WHERE `userid`='".$customer_login."' LIMIT 0,1;"));
					//$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | SELECT * FROM `$tableprefix-wifi-user_tariff` WHERE `userid`='".$customer_login."' LIMIT 0,1; is given ".$cust_tariff_code['tariff_code']);
	
					if($cust_tariff_code['tariff_code']){ # Тариф найден
						$open_tariff = $cust_tariff_code['tariff_code'];
					} else { # Не найден тариф пользователя
						$open_tariff = $rad_def_sp;
					}
					
					# Активируем сессию абонента
					$smp_client = new SoapClient( "$allot_wsdl_path",array("trace" => 1) );
					$smp_request = array('in0' => 
					array(
						'SubscriberService' => array(
							'ip_address'		=> $ip,
							'host_group_name'	=> $open_tariff,
							'external_id'		=> $customer_login
						)
					));
					$smp_client->startSubscriberService($smp_request);
					$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Access for $customer_login ($ip) is opened with tariff ".$open_tariff." in ".$wifi_access_mode." mode");
	
				} elseif ($wifi_access_mode=="radius_Acct"){ //Открываем по radius acct
					$rad_bras_ad_data=explode("/",$rad_bras_ad);
					shell_exec("echo \"User-Name=\"$customer_login\",Acct-Status-Type=\"Start\",Framed-IP-Address=\"$ip\"\" | radclient -x ".$rad_bras_ad_data[0].":".$rad_bras_ad_data[1]." acct ".$rad_bras_ad_data[2]);    
					
					
					$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Access for $customer_login ($ip) is opened across BRAS (".$rad_bras_ad_data[0].") in ".$wifi_access_mode." mode");
				
				} elseif ($wifi_access_mode=="radius_CoA"){  # Основной, частый кейс, ДОДЕЛАТЬ
					$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Access for $customer_login ($ip) is opened across BRAS (".$rad_bras_ad_data[0].") in ".$wifi_access_mode." mode");
				
				}
				# Отвечаем пользователю
				$aRes = array('status' => 'ok', 'message' => '<span style="color:green">'.$sitemessage["system"]["access_granted"].'</span>','getfunction'=>'showblock("next_page_button")');
				echo json_encode($aRes);

				$_SESSION['wifi_logged_in'] = $customer_login;
				$_SESSION['login']=	$customer_login;
				
			}
		} else {$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Can't create radius DB connect");
			echo $sitemessage["registration_form"]["user_cant_be_added"];
		}
	}
	elseif($_REQUEST['action']=="Access_stop"){
		
		if($_SESSION['wifi_logged_in']){
			
			$customer_login=$_SESSION['wifi_logged_in'];
			
			
			include($_SERVER["DOCUMENT_ROOT"]."/core/IPreal.php");//Определяем IP пользователя
			
			if($wifi_access_mode=="Allot_soap_api"){ // Закрыть доступ по SOAP Allot
				
					# Узнаем тариф пользователя
					$cust_tariff_code=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-wifi-user_tariff` WHERE `userid`='".$_SESSION['wifi_logged_in']."' LIMIT 0,1;"));
					
					if($cust_tariff_code['tariff_code']){ # Тариф найден, останавливаем сессию абонента
					
						$smp_client = new SoapClient( "$allot_wsdl_path",array("trace" => 1) );
						$smp_request = array('in0' => 
						array(
							'SubscriberService' => array(
								'ip_address'		=> $ip,
								'host_group_name'	=> $cust_tariff_code['tariff_code'],
								'external_id'		=> $customer_login
							)
						));
						$smp_client->stopSubscriberService($smp_request);
						$session_stopped=1;
					} else { # Не найден тариф пользователя
						$log->LogError(basename (__FILE__)." | ".(__LINE__)." | Can't found tariff of user ".$customer_login);
					}
	
			} elseif ($wifi_access_mode=="radius_Acct"){ //Закрываем по radius acct
			
				$rad_bras_ad_data=explode("/",$rad_bras_ad);
			
				shell_exec("echo \"User-Name=\"$customer_login\",Acct-Status-Type=\"Stop\",Framed-IP-Address=\"$ip\"\" | radclient -x ".$rad_bras_ad_data[0].":".$rad_bras_ad_data[1]." acct ".$rad_bras_ad_data[2]);			
				$session_stopped=1;
			}
			
			if($session_stopped==1){
			
				$aRes = array('status' => 'ok', 'message' => '<span style="color:green">'.$sitemessage["system"]["logout_complete"].'</span>','getfunction'=>'showblock("login-form"),closeblock("next_page_button")');
				unset ($_SESSION['wifi_logged_in']);
				unset($_SESSION['login']);
			} else {
				$aRes = array('status' => 'nok', 'message' => '<span style="color:red">'.$sitemessage["system"]["logout_no_complete"].'</span>','getfunction'=>'showblock("login-form"),closeblock("next_page_button")');
				
			}
			echo json_encode($aRes); // Отвечаем пользователю
			$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Session stopped for ".$customer_login);
		} else {
			
				$aRes = array('status' => 'nok', 'message' => '<span style="color:red">'.$sitemessage["system"]["Login_is_wrong"].'</span>');

				echo json_encode($aRes);
		}
	}
	
	elseif($_REQUEST['action']=="check_login"){# Входят в ЛК
	
		$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Trying to check user credentials");
		$ok_page="wifi_sc_main";

		include("checklogin.php"); 
		
		if($loginresult==1){$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Message has been shown: ".$showmessage);
			
			$aRes = array('status' => 'ok', 'message' => '<span style="color:green">'.$sitemessage['system']['sc_access_granted'].'</span>','getfunction'=>'changerazdel("'.$ok_page.'")');

			$_SESSION['wifi_logged_in']=$customer_login;
			$_SESSION['login']=$customer_login;
		} else $aRes = array('status' => 'nok', 'message' => '<span style="color:red">'.$sitemessage['system']['LoginPass_is_wrong'].'</span>');

		echo json_encode($aRes);		
	
	} elseif($_REQUEST['action']=="change_tariff"){# Меняют тариф
		
		if($_SESSION['wifi_logged_in']){
			if($_REQUEST['sp']){
				$customer_new_tariff=process_data($_REQUEST['sp'],25);
				$customer_login=$_SESSION['wifi_logged_in'];
			
			
				$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | SP ".$customer_new_tariff." has choosen by user");
			
				
				include($_SERVER["DOCUMENT_ROOT"]."/core/IPreal.php");//Определяем IP пользователя
				
				if($wifi_access_vendor=="Allot"){
					# Меняем тариф на Allot
					$smp_client = new SoapClient( "$allot_wsdl_path",array("trace" => 1) );
					$smp_request = array('in0' => 
					array(
						'SubscriberService' => array(
							'ip_address'		=> $ip,
							'host_group_name'	=> $customer_new_tariff,
							'external_id'		=> $customer_login
						)

					));
					$smp_client->startSubscriberService($smp_request);  
					
				}
				
				# Апдейт таблицы со связкой юзеров и тарифов
				# Узнаем тариф пользователя
				$cust_tariff_code=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-wifi-user_tariff` WHERE `userid`='".$_SESSION['wifi_logged_in']."' LIMIT 0,1;"));
				
				if($cust_tariff_code['tariff_code']){ # Тариф найден в БД SWP
				
					mysql_query("UPDATE `$tableprefix-wifi-user_tariff` SET `tariff_code` = '$customer_new_tariff' WHERE `userid` = '$customer_login';");
				
				} else { # Тариф не найден, добавляем связку пользователя и тарифа в БД SWP
				
					$tariff_add_req = mysql_query("INSERT INTO `$tableprefix-wifi-user_tariff` 
					(`raw_id`, `userid`, `tariff_code`) VALUES (NULL, '$customer_login', '$customer_new_tariff');");
				}
				
				$aRes = array('status' => 'ok', 'message' => '<span style="color:green">Ваш тарифный план изменен на '.$customer_new_tariff.'</span>');
				echo json_encode($aRes);
				
			} else {
				$aRes = array('status' => 'nok', 'message' => '<span style"color:green">Тариф не получен от пользователя. Обратитесь к администратору</span>');
				echo json_encode($aRes);
				$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | There is no a new service plan in REQUEST[sp]");
			}
		} else{ 
			$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | User was not found in SESSION params");
		}
	}
} ?>