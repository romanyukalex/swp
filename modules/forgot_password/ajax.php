<?php
 /***************************************************************************
  * Snippet Name : change password (ajax part) 					 			* 
  * Scripted By  : RomanyukAlex		           					 			* 
  * Website      : http://popwebstudio.ru	   					 			* 
  * Email        : admin@popwebstudio.ru     					 			* 
  * License      : GPL (General Public License)					 			* 
  * Purpose 	 : Восстановление забытого пароля по Логину или Телефону	*
  * Access		 : include									 	 			*
  ***************************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
include($_SERVER["DOCUMENT_ROOT"]."/core/system-param.php"); 

	$need_login=process_data($_REQUEST['login'],40);
	$need_contact_phone=process_data($_REQUEST['contact_phone'],28);
	
	
	if (!$need_login and !$need_contact_phone){$showmessage="Заполните все обязательные поля";$messagecolor="red";}
	else{ // Пришли
		include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
		# Поиск пользователя
		if($authlogin=='only_login') {$loginphrase="`login`='$need_login'";}
		elseif($authlogin=='only_email') {$loginphrase="`contactmail`='$need_login'";}
		elseif($authlogin=='both') {$loginphrase="(`login`='$need_login' or `contactmail`='$need_login')";}
		if($need_contact_phone!=="Номер телефона") $loginphrase.=" or `contact_phone`='$need_contact_phone'";
		$forgotpassuser=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` WHERE $loginphrase LIMIT 0,1;"));
		if($forgotpassuser) {
			
			# Активационная ссылка
			insert_function("abracadabra");
			$ActivationLink=abracadabra(15,"mix");
			# Update профиля
			$forgorpassupdatereq=mysql_query("UPDATE `$tableprefix-users` SET `ActivationLink` = '$ActivationLink',`changepassmust` = '2' WHERE `userid` ='$forgotpassuser[userid]';");
			# Выслать письмо
			insert_function("send_letter");
			$subject="Восстановление пароля на портале ".$sitedomainname;
			$message="Здравствуйте, ".$forgotpassuser['fullname']."<br><br>Для восстановления пароля на портале <a href='http://".$sitedomainname."'>www.".$sitedomainname."</a>, пожалуйста, пройдите по ссылке ниже или скопируйте её в адресную строку браузера:<br><br>".
			"<a href='http://".$sitedomainname."/?page=forgot_pass&menu=mainmenu&action=activate&activationlink=".$ActivationLink."'>Восстановить пароль</a><br><br>Если же Вы не имеете отношения к заполнению формы на <a href='http://".$sitedomainname."/?page=forgot_pass&menu=mainmenu'>www.".$sitedomainname."</a>, Вы можете просто проигнорировать это письмо.<bR><br>С наилучшими пожеланиями.<br><b>Администрация сайта ".$sitedomainname;
			sendletter($forgotpassuser['contactmail'],$subject,$message);
			$showmessage="Пользователь найден в базе данных, на указанный e-mail выслано письмо для восстановления пароля";$messagecolor="green";
			$successpage=process_data($_REQUEST['sucpage'],20);
			?><script>$(document).ready(function(){changerazdel('login');});</script>
			<? 			
		} else {$showmessage="Пароль не был изменен";$messagecolor="red";}
	
	}
	echo "<span style='color:".$messagecolor."; font-size:bold'>".$showmessage."</span>";
}
?>