<?php
 /**************************************************************\
  * Modulename	: modulename				 					* 
  * Part		: controller									*
  * Scripted By	: RomanyukAlex		           					* 
  * Website		: http://popwebstudio.ru	   					* 
  * Email		: admin@popwebstudio.ru     					* 
  * License		: GPL (General Public License)					* 
  * Purpose		: control all operations						*
  * Access		: include									 	*
  * if its needed to return some data just add $return_data		*
  \*************************************************************/
$log->LogInfo('Got this file with params - '.implode(',',$param));
if($nitka=='1'){
	insert_function('process_user_data');

	if ($contact=='show_registration_form'){# Страничка с регистрационной формой
	
		// insert_module("registration_form",'show_registration_form');
	
		$show_view='registration_form';
		//$return_data= "OK";
		//$return_data=json_encode(array('status' => $order_status, 'message' => $order_message, 'getfunction'=>$order_function));
		
	} elseif($contact=='addUser'){ #Добавляют нового пользователя. Переделать под контроллер, скопировал со старого
		
		$new_customer_city=process_data($_REQUEST['city'],10);
		$new_customer_email=process_data($_REQUEST['new_customer_email'],40);
		$new_customer_phone=process_data($_REQUEST['new_customer_phone'],15);
		$new_company_country=process_data($_REQUEST['new_company_country'],8);
		$new_company_city=process_data($_REQUEST['new_company_city'],10);
		$new_company_form_b_ownership=process_data($_REQUEST['new_company_form_b_ownership'],10);
		$new_company_full_name=process_data($_REQUEST['new_company_full_name'],150);

		$newfullname=process_data($_REQUEST['newfullname'],40);
		if($_REQUEST['new_company_legal_address']) {$new_company_legal_address="'".process_data($_REQUEST['new_company_legal_address'],1000)."'";} else $new_company_legal_address='NULL';
		if($_REQUEST['new_company_real_address']) {$new_company_real_address=process_data($_REQUEST['new_company_real_address'],1000);$new_company_real_address="'$new_company_real_address'";} else $new_company_real_address='NULL';
		if($_REQUEST['new_company_post_address']) {$new_company_post_address=process_data($_REQUEST['new_company_post_address'],1000);$new_company_post_address="'$new_company_post_address'";} else $new_company_post_address='NULL';
		if($_REQUEST['new_company_inn']) {$new_company_inn=process_data($_REQUEST['new_company_inn'],10);$new_company_inn="'$new_company_inn'";} else $new_company_inn='NULL';
		if($_REQUEST['new_company_kpp']) {$new_company_kpp=process_data($_REQUEST['new_company_kpp'],9);$new_company_kpp="'$new_company_kpp'";} else $new_company_kpp='NULL';
		if($_REQUEST['new_company_bik']) {$new_company_bik=process_data($_REQUEST['new_company_bik'],12);$new_company_bik="'$new_company_bik'";} else $new_company_bik='NULL';
		if($_REQUEST['new_company_domain']) {$new_company_domain=process_data($_REQUEST['new_company_domain'],100);$new_company_domain="'$new_company_domain'";} else $new_company_domain='NULL';
		# Проверка емейла на уникальность
		$userreq=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` WHERE `contactmail`='$new_customer_email'"));
		if(!$userreq[userid]){
			$new_company_req=mysql_query("INSERT INTO `$companiesprefix-companies` (`inn` ,`kpp` ,`bik` ,`company_full_name` ,`country_id` ,`city_id`,`legal_address` ,`form_of_business_ownership` ,`real_address` ,`post_address` ,`company_domain`,`change_date`,`creation_date` )
			VALUES ( $new_company_inn, $new_company_kpp, $new_company_bik, '$new_company_full_name', '$new_company_country','$new_company_city', $new_company_legal_address, '$new_company_form_b_ownership', $new_company_real_address, $new_company_post_address, $new_company_domain,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);");
			
			$new_company_id=mysql_insert_id();

			# Активационная ссылка
			insert_function("abracadabra");
			$ActivationLink=abracadabra(15,"mix");
			$DeactivationLink=abracadabra(15,"mix");

			# Вставляем юзера
			$newcustomerreq=mysql_query("INSERT INTO `$tableprefix-users` (`login` ,`password` ,`userrole` ,`nickname` ,`fullname` ,`company_id` ,
			`contactmail` ,`contact_phone`,`status` ,`timestamp` ,`ActivationLink` ,`DeactivationLink` ,`changepassmust` )
			VALUES ( '', '', 'superuser', '$usernickname', '$newfullname', '$new_company_id', '$new_customer_email','$new_customer_phone', 'created', 
			CURRENT_TIMESTAMP ,'$ActivationLink' , '$DeactivationLink' , '2');");
			if($newcustomerreq) {//Успешно создан пользователь
				# Добавляем юзера в группу public
				$new_userid=mysql_insert_id();
				mysql_query("INSERT INTO `$tableprefix-users-groupmembers` (`group_id` ,`userid` )VALUES ( '2', '$new_userid');");
				insert_function("send_letter");
				$subject="Подтверждение регистрации на портале ".$sitedomainname;
				$message="Здравствуйте, ".$newfullname.".<br><br>Вы успешно зарегистрировались на портале <a href='http://".$sitedomainname."' target='_blank'>".$sitedomainname."</a><br><br>Для продолжения регистрации, пожалуйста, пройдите по ссылке ниже или скопируйте её в адресную строку браузера:<br><br>".
				"Активация профиля абонента: <a href='http://".$sitedomainname."/?page=register&menu=mainmenu&action=activate&activationlink=".$ActivationLink."' target='_blank'>http://".$sitedomainname."/?page=register&menu=mainmenu&action=activate&activationlink=".$ActivationLink."</a><br><br>Если же Вы не имеете отношения к заполнению формы на <a href='http://".$sitedomainname."'>".$sitedomainname."</a>, Вы можете пройти по ссылке ниже или просто проигнорировать это письмо.<br>".
				"<a href='http://".$sitedomainname."/?page=register&menu=mainmenu&action=deactivate&deactivationlink=".$DeactivationLink."' target='_blank'>Я не заполнял форму на портале ".$sitedomainname."</a>".
				"<br><br>С наилучшими пожеланиями.<br><b> ".$from."</b><br><br><br>---------------------------<br>
				Это письмо создано роботом и не требует ответа!<br>
				Вопрос можно оставить на странице http://".$sitedomainname."/?page=contact_form";
				sendletter($new_customer_email,$subject,$message);
				?>
				<div id="regform_answer" class="checkbox-radio-css3-show">
						<h1>Ваша заявка на регистрацию принята:</h1>
						<br>
							<form>
							<? if($new_company_req){?>
							<p>
							<input id="r1" type="radio" value="1" name="r1" selected="selected">
						   <label><span></span>Создана компания <?=$new_company_full_name?></label>
							</p><? }?>
							<p>
							<input id="r2" type="radio" value="1" name="r2" selected="selected">
						   <label><span></span>Создан пользователь <?=$new_customer_email?></label>
							</p>
							</p>
							</form>
							<p>
							<?=sitemessage("registration_form","mail_was_sent");?>
							</p>
						
				</div><?
			}
			else echo sitemessage("registration_form","user_cant_be_added");//"Не удалось добавить пользователя";
		} else echo sitemessage("registration_form","user_already_exists");//"Пользователь с указанным email уже существует";		
	} elseif($contact=='activate'){ #Активация почтового адреса
		
		$activationlink=process_data($_REQUEST['activationlink'],15);
		$log->LogDebug('ActivationLink is '.$activationlink);	
		$user=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` WHERE `ActivationLink`='$activationlink' and `status`='created' LIMIT 0 , 1"));
		

		if($user['userid']){// Пользователь найден по параметру ActivationLink
		
			if($adminallowaccess=='Подтверждения администратором'){$set_status = 'admin_suspensed';
			} elseif($adminallowaccess=='Подтверждения емейла пользователем'){$set_status = 'active';}
			else $set_status = 'deactive';
			$log->LogDebug('User status will be '.$set_status);
			$def_passwd='password';
			
			$activateuserreq=mysql_query("UPDATE `$tableprefix-users` SET `status` = '$set_status',`ActivationLink` = '',`DeactivationLink` = '',`password`='5f4dcc3b5aa765d61d8327deb882cf99' WHERE `userid` ='$user[userid]';");		
			
			if($activateuserreq){ // Активирован
				
				if($new_cust_notify=="Оповещать"){
					if ($user['company_id'] and $user['company_id']!=="0"){
						$company_exists=1;
						# Узнаем подробности о компании
						$company_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` u,`$companiesprefix-companies` c 
						WHERE  u.`company_id`=c.`company_id` and u.`userid`='$user[userid]' LIMIT 0 , 1"));
					}
					insert_function('send_letter');
					$subject='Новый пользователь зарегистрирован на портале '.$sitedomainname;
					$message="Здравствуйте<br><br>На портале <a href='http://".$sitedomainname."'>".$sitedomainname.'</a> был зарегистрирован новый пользователь';
					if($company_exists) $message.=' и новая компания';
					$message.='</a><br><br><b>Данные пользователя</b><br>ID='.$user['userid'].' ИМЯ='.$user['fullname'].' EMAIL='.$user['contactmail'].' ТЕЛЕФОН='.$user['contact_phone'].'<br><br>';
					if($company_exists) $message.='<b>Компания</b><br>'.$company_info['form_of_business_ownership'].' '.$company_info['company_full_name'].'<br>'.$company_info['legal_address'].'<br><br>';
					$message.=$from.' ['.$sitedomainname.']';
					sendletter($officialemail,$subject,$message);
	
				}
				$show_view='activate_success';
				$log->LogDebug('User activated his email. User status now is '.$set_status);	
				
			}
	 
		} else {$log->LogError('User is not found via activationlink');	
			$show_view='activate_failed';
		}
	
	}
}
?>