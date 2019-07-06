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

	$new_user_country=process_data($_REQUEST['country'],8);
	$new_customer_city=process_data($_REQUEST['city'],10);
	$new_customer_email=process_data($_REQUEST['new_customer_email'],100);
	$new_customer_phone=process_data($_REQUEST['new_customer_phone'],15);
	$new_name=process_data($_REQUEST['new_name'],40);
	$new_family=process_data($_REQUEST['new_family'],40);

	# Проверка емейла на уникальность
	$userreq=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` WHERE `contactmail`='$new_customer_email'"));
	if(!$userreq['userid']){
		
		/*
		#Создаем ТЦ
		$new_company_req=mysql_query("INSERT INTO `$companiesprefix-companies` (`inn` ,`kpp` ,`bik` ,`company_full_name` ,`country_id` ,`city_id`,`legal_address` ,`form_of_business_ownership` ,`real_address` ,`post_address` ,`company_domain`,`change_date`,`creation_date` )
		VALUES ( $new_company_inn, $new_company_kpp, $new_company_bik, '$new_company_full_name', '$new_user_country','$new_company_city', $new_company_legal_address, '$new_company_form_b_ownership', $new_company_real_address, $new_company_post_address, $new_company_domain,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);");
		
		$new_company_id=mysql_insert_id();
		*/
		# Активационная ссылка
		insert_function("abracadabra");
		$ActivationLink=abracadabra(15,"mix");
		$DeactivationLink=abracadabra(15,"mix");
		
		# Вставляем юзера
		$newcustomerreq=mysql_query("INSERT INTO `$tableprefix-users` (`login` ,`password` ,`userrole` ,`second_name` ,`first_name` ,
		`contactmail` ,`contact_phone`,`status` ,`timestamp` ,`ActivationLink` ,`DeactivationLink` ,`changepassmust` )
		VALUES ( NULL, NULL, 'user', '$new_family', '$new_name', '$new_customer_email','$new_customer_phone', 'created', 
		CURRENT_TIMESTAMP ,'$ActivationLink' , '$DeactivationLink' , '2');");
		if($newcustomerreq) {//Успешно создан пользователь
			
			$new_userid=mysql_insert_id();
			
			insert_function("send_letter");
			$subject="Подтверждение регистрации на портале ".$sitedomainname;
			$message="Здравствуйте, ".$newfullname.".<br><br>Вы успешно зарегистрировались на портале <a href='http://".$sitedomainname."' target='_blank'>".$sitedomainname."</a><br><br>Для продолжения регистрации, пожалуйста, пройдите по ссылке ниже или скопируйте её в адресную строку браузера:<br><br>".
			"Активация профиля: <a href='https://".$sitedomainname."/?page=register&action=activate&activationlink=".$ActivationLink."' target='_blank'>https://".$sitedomainname."/?page=register&action=activate&activationlink=".$ActivationLink."</a><br><br>Если же Вы не имеете отношения к заполнению формы на <a href='http://".$sitedomainname."'>".$sitedomainname."</a>, Вы можете пройти по ссылке ниже или просто проигнорировать это письмо.<br>".
			"<a href='https://".$sitedomainname."/?page=register&action=deactivate&deactivationlink=".$DeactivationLink."' target='_blank'>Я не заполнял форму на портале ".$sitedomainname."</a>".
			"<br><br>С наилучшими пожеланиями.<br><b> ".$from."</b><br><br><br>---------------------------<br>
			<i>Это письмо создано роботом и не требует ответа!<br>
			Вопрос можно оставить на странице https://".$sitedomainname."/?page=contact_form</i>";
			sendletter($new_customer_email,$subject,$message);
			
			$aRes = array('status' => 'ok', 'message' => 'Ваша заявка на регистрацию принята. <br>'.sitemessage("registration_form","mail_was_sent"),'getfunction'=>
			//'changerazdel("'.$_SESSION['redirect_url'].'")');
			'showHideSelectionSoft("next_page_button",2000);pause(5000);changerazdel_byURL("'.$_SESSION['redirect_url'].'")');
			echo json_encode($aRes);
			$_SESSION['registered']=1;//Флаг, что он зарегистрировался
		}
		else {
			echo sitemessage("registration_form","user_cant_be_added");//"Не удалось добавить пользователя";
		}
	} else {//"Пользователь с указанным email уже существует";
		$aRes = array('status' => 'nok', 'message' =>sitemessage('registration_form','user_already_exists'),'getfunction'=>'showHideSelectionSoft("want_toLogin",2000)');
		echo json_encode($aRes);
	}		

}
?>