<? $log->LogInfo('Got this file');
if($_REQUEST['action']=='activate' and $nitka=='1'){
	
	//@include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	//@include_once($_SERVER["DOCUMENT_ROOT"]."/core/system-param.php");
	//@include_once($_SERVER["DOCUMENT_ROOT"]."/core/messages.php");#Все сообщения портала на языке портала
	$activationlink=process_data($_REQUEST['activationlink'],15);
	
	$user=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` WHERE `ActivationLink`='$activationlink' and `status`='created' LIMIT 0 , 1"));
	
	?><div id="regform_answer" class="checkbox-radio-css3-show"><?
	if($user['userid']){// Пользователь найден
		if($adminallowaccess=='Подтверждения администратором'){$set_status = 'admin_suspensed';
		} elseif($adminallowaccess=='Подтверждения емейла пользователем'){$set_status = 'active';}
		else $set_status = 'deactive';
		
		//insert_function("Password"); // Вставили класс
		//$Password = new Password( $Secret, array('AccountLevel' => 'MEDIABOX', 'UserName' => $row['WEBLOGIN'], 'CustomerName' => $row['CUSTOMERNAME']));
		/*if (!$Password || !$Password->isValid()) {
			Log::notice("3315 : Password does not fulfill the security rules", __FILE__, __LINE__);
			return xmlErrorResponse('3315');
		}*/
		$def_passwd='password';
		
		# Проверка существования поля pass_salt
		
		# Если поле есть:
		#Генерация соли
		
		# Прибавляем default_pass + соль, делаем md5. Это все будет записано в поле password
		
		$activateuserreq=mysql_query("UPDATE `$tableprefix-users` SET `status` = '$set_status',`ActivationLink` = '',`DeactivationLink` = '',`password`='5f4dcc3b5aa765d61d8327deb882cf99' WHERE `userid` ='$user[userid]';"); // добавить соль в этот insert
		
		
		# Если pass_salt нет, то старая логика:
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
			}?>
			<h1>Пользователь успешно активирован<? if($_REQUEST['action2']!==2){?>:<? }?></h1>
		<? if($_REQUEST['action2']!==2){?><br><p><? echo $sitemessage[$modulename]['activation_complete'];?><br>
				<? if($usrcntctafteractiv=='Показывать') {
					if($user['login']) echo $user['login'].'<br>';
					if($user['contact_phone']) echo $user['contact_phone'].'<br>';
					if($user['contactmail']) echo $user['contactmail'].'<br>';
				}?></p><? }?>
		<?
		}
 
	} else {?><h1>Пользователь не активирован:</h1>
	<p><?=$sitemessage[$modulename]['wrong_activation_qry'];	
	//Неправильная строка активации или пользователь уже был активирован ранее.
		
	?></p>
<?	}
	?></div><?
}
?>