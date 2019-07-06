<?php
 /***************************************************************\
  * Snippet Name : usersmanagement (ajax part) 					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : some ajax functions							 *
  * Access		 : include									 	 *
  \**************************************************************/
$log->LogInfo('Got this file');

//include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
//include_once($_SERVER['DOCUMENT_ROOT']."/core/system-param.php");
include($_SERVER['DOCUMENT_ROOT']."/core/checkuserrole.php"); // Определяем userrole
if(isset($_REQUEST['someid']) and $_REQUEST['someid']=="create_user"){
	if ( $userrole=='superuser'){
		$userlogin=process_data($_REQUEST['userlogin'],20);
		$userpasswordtype=process_data($_REQUEST['userpasswordtype'],1);
		if($userpasswordtype=='2'){$userpassword=process_data($_REQUEST['userpassword'],40);$chpassmust=process_data($_REQUEST['chpassmust'],1);}
		else {$userpassword=md5($defaultpassword);$chpassmust=2;}
		$need_userrole='user';
		$usernickname=process_data($_REQUEST['usernickname'],40);
		$userfullname=process_data($_REQUEST['userfullname'],100);
		$need_company_id=$company_id;
		$usercontactmail=process_data($_REQUEST['usercontactmail'],40);
		$activationpath=process_data($_REQUEST['activationpath'],10);
		
		//include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
		# Проверка емейла на уникальность
		$userreq=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` WHERE `contactmail`='$usercontactmail'"));
		if(!$userreq[userid]){//Такого емейл не нашли
			if($activationpath=='sendletter'){
				# Активационная ссылка
				insert_function('abracadabra');
				$ActivationLink=abracadabra(15,'mix');
				$DeactivationLink=abracadabra(15,'mix');
				$new_user_status='created';
			} elseif($activationpath=='activate') {$new_user_status='active';}
		
			$insertuserreq=mysql_query("INSERT INTO `$tableprefix-users` (`login` ,`password` ,`userrole` ,`nickname` ,`fullname` ,`company_id` ,
	`contactmail` ,`status` ,`timestamp` ,`regsecretkey` ,`ActivationLink` ,`DeactivationLink` ,`changepassmust` )
	VALUES ( '$userlogin', '$userpassword', '$need_userrole', '$usernickname', '$userfullname', '$need_company_id', '$usercontactmail', '$new_user_status', 
	CURRENT_TIMESTAMP , NULL , '$ActivationLink' , '$DeactivationLink' , '$chpassmust');");
			if($insertuserreq) {
				echo sitemessage('system','new_user_succ_added');//"Пользователь успешно добавлен";
				echo "<script>$(document).ready(function(){ajaxreq('','','show_users_table','usermanagetable','usersmanagement');})</script>";
				if($activationpath=='sendletter'){ // Посылаем активационное письмо
				insert_function('send_letter');
				$subject='Подтверждение регистрации на сайте '.$sitedomainname;
				$message='Здравствуйте, '.$userfullname."<br><br>Вы успешно зарегистрировались на портале <a href='http://".$sitedomainname."'>www.".$sitedomainname.'</a><br><br>Для продолжения регистрации, пожалуйста, пройдите по ссылке ниже или скопируйте её в адресную строку браузера:<br><br>'.
				"<a href='http://".$sitedomainname.'/?page=register&menu=mainmenu&action=activate&action2=2&activationlink='.$ActivationLink."'>Активация профиля абонента</a><br><br><br>С наилучшими пожеланиями.<br><b>Администрация сайта ".$sitedomainname;
				sendletter($usercontactmail,$subject,$message);
				}
			}
			else echo sitemessage('system','new_user_is_not_inserted');//"Не удалось добавить пользователя";
		} else echo sitemessage('system','email_already_exists');//"Пользователь с таким email уже существует в системе";
	} else echo sitemessage('system','you_have_no_privileges_for_operation');//"Не хватает привилегий для добавления пользователя";
}
elseif ($_REQUEST['action']=='show_usmanag_page'){//Показать страничку с таблицами юзеров и новым юзером
	include($_SERVER['DOCUMENT_ROOT'].'/core/usersmanagement/users_management_page.php');
	
}
elseif ($_REQUEST['action']=='show_comp_page'){
	include($_SERVER['DOCUMENT_ROOT'].'/core/usersmanagement/companies_management_page.php');
}
elseif ($_REQUEST['action']=='show_companies_table'){
	if($userrole=='admin' or $userrole=='root'){
		$comp_info_q=mysql_query("SELECT * FROM `$companiesprefix-companies` c,`$tableprefix-country` cr,`$tableprefix-cities` ct WHERE c.`country_id`=cr.`id` and c.`city_id`=ct.`id`;");
		while($comp_info=mysql_fetch_array($comp_info_q)){
			?><tr>
				<td title="ID компании = <?=$comp_info['company_id']?>"><?=$comp_info['form_of_business_ownership'].' '.$comp_info['company_full_name']?></td>
				<td><?=$comp_info['country_name_'.$language].",".$comp_info['city_name_'.$language]?><br>
					Реал.адрес: <?=$comp_info['real_address']?><br>
					Юр.адрес: <?=$comp_info['legal_address']?><br>
					Почт.адрес: <?=$comp_info['post_address']?><br>
				</td>
				<td>
					ИНН: <?=$comp_info['inn']?><br>
					КПП: <?=$comp_info['kpp']?><br>
					БИК: <?=$comp_info['bik']?><br>
				</td>
				<td><?=$comp_info['company_domain']?></td>
				<td>
					<a href="" title="Редактировать" onclick="open_change_user_form(<?=$userlist['userid']?>);return false;"><img src="/files/simplicio/file_edit.png"></a>
					<a href="" title="Список пользователей" onclick="open_change_user_form(<?=$userlist['userid']?>);return false;"><img src="/files/simplicio/user.png"></a>
					<a href="" title="Удалить" onclick="delete_user(<?=$userlist['userid']?>);return false;"><img src="/files/simplicio/button_cancel.png"></a>
					
				</td>
			</tr>
			<?
		}
	}
}
elseif ($_REQUEST['action']=='show_users_table'){
	insert_function("getAge");
	if($userrole=='admin' or $userrole=='root' and !isset($REQUEST['company_id'])){$needcompany_id=0;}
	global $tableprefix,$companiesprefix;
	
	if(($userrole!=='root' and $userrole!=='admin') or (isset($company_id) and $company_id!==0)){
		$userlistreqtxt="SELECT * FROM `$tableprefix-users` u, `$companiesprefix-companies` c WHERE u.`company_id`='$company_id' and c.`company_id`=u.`company_id`";
	}
	else $userlistreqtxt="SELECT * FROM `$tableprefix-users` u LEFT JOIN `$companiesprefix-companies` c ON c.`company_id`=u.`company_id`";
	$userlistreqtxt.=' ORDER BY `status` DESC';
	
	$userlistreq=mysql_query($userlistreqtxt);
	
	$n=1;
	while($userlist=mysql_fetch_array($userlistreq)){?>
		<tr>
			    
			<td title="Уникальный номер пользователя: [<?=$userlist['company_id']."-".$userlist['userid']?>] <?if($userlist['fullname']) echo $userlist['fullname']; else echo $userlist['second_name'].' '.$userlist['first_name']?>">
				
				<div id="fullnametext<?=$userlist['userid']?>">
				<? if($userlist['user_photo']){?><img src="<?=$userlist['user_photo']?>"><?}?>
				<?if($userlist['fullname']) echo $userlist['fullname']; else echo $userlist['second_name'].' '.$userlist['first_name']?></div>
				
			</td>
			<td>
			<?if($authlogin=='only_login'){
				?><div id="logintext<?=$userlist['userid']?>"><?=$userlist['login']?></div><?
			}
			elseif($authlogin=='only_email'){
				?><div id="contactmailtext<?=$userlist['userid']?>"><?=$userlist['contactmail']?></div><?
			}
			elseif($authlogin=='both'){?>
				<?if($userlist['login']){?><span id="logintext<?=$userlist['userid']?>"><?=$userlist['login']?></span><?} else echo "НЕТ";?>;
				<?if($userlist['contactmail']){?><span id="contactmailtext<?=$userlist['userid']?>"><?=$userlist['contactmail']?></span><?} else echo "НЕТ";
			}?>
				
				
			</td>
			<td>
				<div id="contact_phone<?=$userlist['userid']?>"><?=$userlist['contact_phone']?></div>
				
			</td>
			<? if($userrole=="root" or $userrole=="admin"){?>
			<td>
				<div id="company<?=$userlist['userid']?>" title="Company_id = <?=$userlist['company_id']?>"><?=$userlist['company_full_name']?></div>
				
			</td>
			<?}?>
			<td>
			<? #Роль ?>
			<span title="Роль на портале <?
			if($userlist['fullname']) echo $userlist['fullname']; else echo $userlist['second_name'].' '.$userlist['first_name'];
			if($userlist['userrole']=="user"){echo ": пользователь";}
			elseif($userlist['userrole']=="superuser"){echo ": суперпользователь";}?>">
			<?if($userlist['userrole']=="user"){?>П<?}
			elseif($userlist['userrole']=="superuser"){ ?>СП<?}?>
			</span>
			<? #Пол ?>
			<img src="/adminpanel/pics/<?if($userlist['gender']=="male"){ ?>Male<?}elseif($userlist['gender']=="female"){?>Female<?}elseif($userlist['gender']=="-"){?>question-type-true-false<?}?>256.png" width="64px" title="Пол: <?=$userlist['gender']?>">
			<? #Страна ?>
			
			<? #Статус ?>
			<img title="Статус активности: <? if($userlist['status']) echo $userlist['status'];else echo "не определен";?>" src="/files/simplicio/<? 	
			if($userlist['status']=="active") {?>ok.png<? }
			elseif($userlist['status']=="deactivated" or $userlist['status']=="deactivate"){?>player_stop.png<? }
			elseif($userlist['status']=="created" or $userlist['status']=="admin_suspensed" or $userlist['status']=="admin_suspended"){?>notification_warning.png<? }
			elseif($userlist['status']=="blocked"){?>notification_error.png<? }
			elseif(!$userlist['status'] or $userlist['status']=='' or $userlist['status']==NULL){?>notification_error.png<? }
			?>" width="20px">
			<? #ДР ?>
			<?if ($userlist['birthdate']=="")?>
			</td>
			<td><div id="manageicons<?=$userlist['userid']?>">
			<a href="" title="Редактировать" onclick="open_change_user_form(<?=$userlist['userid']?>);return false;"><img src="/files/simplicio/file_edit.png"></a>
			<? if($userlist['status']=="active"){?><a href="" title="Заблокировать" onclick="block_user(<?=$userlist['userid']?>);return false;"><img src="/files/simplicio/security_lock.png"></a><? }?>
			<? if($userlist['status']=="blocked" or $userlist['status']=="deactivated"or $userlist['status']=="deactivate" or $userlist['status']=="admin_suspensed" or $userlist['status']=="admin_suspended"){?><a href="" title="Активировать"onclick="unblock_user(<?=$userlist['userid']?>);return false;"><img src="/files/simplicio/direction_up.png"></a><? }?>
			<a href="" title="Удалить" onclick="delete_user(<?=$userlist['userid']?>);return false;"><img src="/files/simplicio/button_cancel.png"></a>
			
			</div>
			
			</form>
			</td>
		</tr>
		<tr id="user<?=$userlist['userid']?>form_tr" style="display:none">
			<td colspan="5"  id="user<?=$userlist['userid']?>form_td">
				<form id="user<?=$userlist['userid']?>form">
				<table><tbody>
				<tr><td></td><td><a style="position:absolute;right:20px;margin-top:10px" onclick="closeformtd(<?=$userlist['userid']?>);return false;"><?if($projectname=="tscloud"){?><img src="/project/tscloud/files/close.png" style="width:10px"><?}else echo "<b>X</b>";?></a></td></tr>
				<tr><td>Логин</td><td width="30px"><b>:</b></td><td><input name="need_login" value="<?=$userlist['login']?>" id="loginfield<?=$userlist['userid']?>" size="50"></td></tr>
				<tr><td width="200px">Никнейм</td><td width="30px"><b>:</b></td><td><input name="nickname" value="<?=$userlist['nickname']?>" id="nicknamefield<?=$userlist['userid']?>" size="50"></td></tr>
				<?if($userlist['fullname']) {?><tr><td>Полное Имя</td><td><b>:</b></td><td><input name="fullname" value="<?=$userlist['fullname']?>" id="fullnamefield<?=$userlist['userid']?>" size="50"></td></tr><? }?>
				<tr><td>Фамилия</td><td><b>:</b></td><td><input name="second_name" value="<?=$userlist['second_name']?>" id="fullnamefield<?=$userlist['userid']?>" size="50"></td></tr>
				<tr><td>Имя</td><td><b>:</b></td><td><input name="first_name" value="<?=$userlist['first_name']?>" id="firstnamefield<?=$userlist['userid']?>" size="50"></td></tr>
				<tr><td>Отчество</td><td><b>:</b></td><td><input name="patronymic_name" value="<?=$userlist['patronymic_name']?>" id="patronymicnamefield<?=$userlist['userid']?>" size="50"></td></tr>
				<tr><td>Пол</td><td><b>:</b></td><td>
					<img src="/adminpanel/pics/Male256.png" width="64px"><input type="radio" name="gender" id="genderfield<?=$userlist['userid']?>" value="male"<?if($userlist['gender']=="male") echo "checked";?>>
					<img src="/adminpanel/pics/Female256.png" width="64px"><input type="radio" name="gender" id="genderfield<?=$userlist['userid']?>" value="female"<?if($userlist['gender']=="female") echo "checked";?>>
					<img src="/adminpanel/pics/question-type-true-false256.png" width="64px"><input type="radio" name="gender" id="genderfield<?=$userlist['userid']?>" value="-"<?if($userlist['gender']=="-") echo "checked";?>></td></tr>
				<tr><td>ДР</td><td><b>:</b></td><td><input name="birthdate" value="<? if ($userlist['birthdate'] and $userlist['birthdate']!=="0000-00-00") echo $userlist['birthdate'];?>" id="birthdatefield<?=$userlist['userid']?>" size="50"><? if($userlist['birthdate'] and $userlist['birthdate']!=="0000-00-00"){echo "<br>( Полных лет: ".getAge($userlist['birthdate'])." )";
				}?></td></tr>
				<tr><td>Электронная почта</td><td><b>:</b></td><td><input name="contactmail" value="<?=$userlist['contactmail']?>" id="contactmailfield<?=$userlist['userid']?>" size="50"></td></tr>
				<tr><td>Телефон</td><td><b>:</b></td><td><input name="contact_phone" value="<?=$userlist['contact_phone']?>" id="contactmailfield<?=$userlist['userid']?>" size="50"></td></tr>
				<tr><td>СоглОбрПерсДанных</td><td><b>:</b></td><td><input type="checkbox" name="is_allowed_personal" id="is_allowed_personalfield<?=$userlist['userid']?>"<?if($userlist['is_allowed_personal']){?> checked<?}?>></td></tr>
				<tr><td>Пароль</td><td><b>:</b></td><td>
					<a href="" onclick="set_default_pass(<?=$userlist['userid']?>);return false;">Задать пароль по-умолчанию</a><br>
					<a onclick="send_new_pass(<?=$userlist['userid']?>)">Выслать новый пароль</a></td></tr>
				
				
				
				<tr><td colspan="2">
				<? if($projectname=="tscloud"){?><input type="image" src="/project/tscloud/files/send.png" onclick="close_change_user_form(<?=$userlist['userid']?>); return false;"><?}
				else{?><a onclick="close_change_user_form(<?=$userlist['userid']?>); return false;" class="small button blue light-rounded">Сохранить</a><?}?>
				</td></tr>
				</table></form>
			</td>
		</tr>
	<? $n++;
	}
	?>
	<script>
	function delete_user(user_id){ajaxreq(user_id,'','delete_user','usertable_messageplace','usersmanagement');}
	function open_change_user_form(user_id){
		$('#manageicons'+user_id).hide(200);
		$('#user'+user_id+'form_tr').fadeIn(400);

	}
	function close_change_user_form(user_id){
		closeformtd(user_id);
		//saveform(user_id,'user'+user_id+'form','usertable_messageplace','usersmanagement','change_user_parameters');
		saveform2(user_id,'user'+user_id+'form','usertable_messageplace','usersmanagement','change_user_parameters','','');
		ajaxreq('','','show_users_table','usermanagetable','usersmanagement');// Обновили таблицу пользователей
	}
	function block_user(user_id){ajaxreq(user_id,'','block_user','usertable_messageplace','usersmanagement');}
	function unblock_user(user_id){ajaxreq(user_id,'','unblock_user','usertable_messageplace','usersmanagement');}
	function closeformtd(user_id){
		$('#user'+user_id+'form_td').hide(200);
		$('#manageicons'+user_id).show(400);
	}
	function set_default_pass(user_id){
		ajaxreq(user_id,'','set_default_pass','usertable_messageplace','usersmanagement');
		closeformtd(user_id);
	}
	function send_new_pass(user_id){
		ajaxreq(user_id,'','send_new_pass','usertable_messageplace','usersmanagement');
	}
	</script>
	<?
}
elseif ($_REQUEST['action']=="delete_user"){
	$need_userid=process_data($_REQUEST['someid1'],5);
	$deleteusereq=mysql_query("DELETE FROM `$tableprefix-users` WHERE `userid` =$need_userid");
	if($deleteusereq){echo "<span style='color:green'>Пользователь успешно удален</span>";?>
		<script>$(document).ready(function(){ajaxreq('','','show_users_table','usermanagetable','usersmanagement');})</script><?
	}else {
		$log->LogDebug("User is not deleted. ".mysql_errno() . ": " . mysql_error());
		echo "<span style='color:red'>Пользователь не удален</span>";
	}
}
elseif ($_REQUEST['action']=="block_user" or $_REQUEST['action']=="unblock_user"){
	$need_userid=process_data($_REQUEST['someid1'],5);
	if ($_REQUEST['action']=="block_user") {$status="blocked";}
	elseif ($_REQUEST['action']=="unblock_user") {$status="active";}
	$updateusereq=mysql_query("UPDATE `$tableprefix-users` SET `status` = '$status' WHERE `userid` =$need_userid;");
	if($updateusereq){echo "<span style='color:green'>Статус пользователя успешно изменен</span>";?>
		<script>$(document).ready(function(){ajaxreq('','','show_users_table','usermanagetable','usersmanagement');})</script><?
	}else {
		$log->LogDebug("Status is not changed. ".mysql_errno() . ": " . mysql_error());
		echo "<span style='color:red'>Статус пользователя не изменен</span>";
	}
}
elseif ($_REQUEST['action']=="change_user_parameters"){
	$need_userid=process_data($_REQUEST['someid'],5);
	$need_login=process_data($_REQUEST['need_login'],40);
	//userrole
	$need_nickname=process_data($_REQUEST['nickname'],40);
	$need_fullname=process_data($_REQUEST['fullname'],200);
	$need_second_name=process_data($_REQUEST['second_name'],100);
	$need_first_name=process_data($_REQUEST['first_name'],100);
	$need_patronymic_name=process_data($_REQUEST['patronymic_name'],100);
	$need_gender=process_data($_REQUEST['gender'],6);
	$need_birthdate=process_data($_REQUEST['birthdate'],20);
	insert_function("getAge");
	if(getAge($need_birthdate)>17) $need_adult=1; else $need_adult=0;
	//company_id
	$need_contactmail=process_data($_REQUEST['contactmail'],40);
	$need_contact_phone=process_data($_REQUEST['contact_phone'],20);
	
	//$need_is_allowed_personal=process_data($_REQUEST['is_allowed_personal'],2);
	if ($_REQUEST['is_allowed_personal']=="on"){$need_is_allowed_personal="1";}
	else $need_is_allowed_personal="0";
	
	$updateusereq_q="UPDATE `$tableprefix-users` SET 
	
	`login` = '$need_login',
	`nickname` = '$need_nickname',
	`fullname` = '$need_fullname',
	`second_name` = '$need_second_name',
	`first_name` = '$need_first_name',
	`patronymic_name` = '$need_patronymic_name',
	`gender` = '$need_gender',
	`birthdate` = '$need_birthdate',
	`adult` = '$need_adult',
	`contactmail`='$need_contactmail',
	`contact_phone`='$need_contact_phone',
	`is_allowed_personal`='$need_is_allowed_personal' 
	
	WHERE `userid` =$need_userid;";
	
	$updateusereq=mysql_query($updateusereq_q);
	if($updateusereq){
		$log->LogDebug("Updated successfully");
		echo "<span style='color:green'>Параметры пользователя (";
		if($need_fullname){echo $need_fullname;}
		elseif($need_second_name or $need_first_name){echo $need_second_name.' '.$need_first_name.' '.$need_patronymic_name;}
		echo ") успешно изменены</span>";
	?>
		<script>$(document).ready(function(){ajaxreq('','','show_users_table','usermanagetable','usersmanagement');})</script><?
	}else {
		$log->LogDebug("Can't update. ".mysql_errno() . ": " . mysql_error());
		echo "<span style='color:red'>Параметры пользователя не изменены</span>";
	}
}
elseif ($_REQUEST['action']=="set_default_pass"){
	$need_userid=process_data($_REQUEST['someid1'],5);
	if($userrole=="superuser" or $userrole=="root" or $userid==$need_userid){
		//$need_userid=process_data($_REQUEST['someid1'],5);
		if($userrole=="superuser"){
			$needuserdata=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` WHERE `userid`='$need_userid' LIMIT 0,1"));
			if($needuserdata[company_id]!==$company_id){ echo "<span style='color:red'>".sitemessage('system',"you_have_no_privileges_for_operation"]." (umaj1)</span>";
				$dontupdate=1;
			}
		}
		if(!$dontupdate){
			insert_function("abracadabra");
			$ActivationLink=abracadabra(15,"mix");
			# Update профиля
			$passupdatereq=mysql_query("UPDATE `$tableprefix-users` SET `ActivationLink` = '$ActivationLink',`changepassmust` = '2',`password`='".md5($defaultpassword)."' WHERE `userid` ='$need_userid';");
			if($passupdatereq){
				$log->LogDebug("Password updated successfully");
				echo "<span style='color:green'>Пароль успешно сброшен</span>";
			} else {
				$log->LogDebug("usersmanagement/".basename (__FILE__)." | Can't set pass. ".mysql_errno() . ": " . mysql_error());
				echo "<span style='color:red'>Пароль пользователя не сброшен</span>";
			}
		}
	} else echo "<span style='color:red'>".sitemessage('system',"you_have_no_privileges_for_operation")." (umaj2)</span>";
}
elseif ($_REQUEST['action']=="send_new_pass"){#Послать пользователю новый пароль
	$need_userid=process_data($_REQUEST['someid1'],5);
	insert_function("abracadabra");
	$newpass=abracadabra(8,"mix");
	$newpass_md5=md5($newpass);
	mysql_query("UPDATE `$tableprefix-users` SET `password` = '$newpass_md5' WHERE `userid` = '$need_userid';");
	$need_user_data=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` WHERE `userid` = '$need_userid';"));
	if($need_user_data['fullname']) $to_email_name=$need_user_data['fullname'];
	else $to_email_name=$need_user_data['second_name'].' '.$need_user_data['first_name'];
	
	$subject="[".$sitedomainname."] Ваш пароль для входа на портал был обновлён";
	$message="
	<html>
	<body>
	<table><tr><td>
	<img src='http://".$sitedomainname.$logofile."' width='64px'>
	</td><td>
	<h4>".$logoalt."</h4>
	</td></tr></table><br>
		<p style='margin:0 auto;'>
		Здравствуйте, ";
	if($need_user_data['gender']=="male" or $need_user_data['gender']=="-") $message.="уважаемый ";
	elseif($need_user_data['gender']=="female") $message.="уважаемая ";
	if($need_user_data['first_name']) $message.=$need_user_data['first_name'].' '.$need_user_data['patronymic_name'];
	else $message.=$need_user_data['fullname'];
	$message.=".<br><br>На портале $sitedomainname был изменен пароль Вашего аккаунта.<br><br>
		<table><tr><td>Логин:<br>Пароль:<br>
		</td><td>".$need_user_data['contactmail']."<br>".$newpass."</td></tr></table>
		</p><p><hr>С уважением, ".$from."<br>Автоматический скрипт<br><br><small style='color:red'>Не отвечайте на это письмо</small></p>
	</body>
	</html>";
	
	insert_function("send_letter");
	sendletter_full($to_email_name,$need_user_data['contactmail'],$subject,$message,$from,$officialemail);	
	echo "[OK] ".sitemessage("change_password","pass_changed_succ")." (";
	if($need_user_data['fullname']) echo $need_user_data['fullname'];
	else echo $need_user_data['second_name'].' '.$need_user_data['first_name'];
	echo ")";

}
elseif ($_REQUEST['action']=="logout"){ # Пользователь выходит из сессии
	@include_once($_SERVER['DOCUMENT_ROOT']."/core/usersmanagement/logout.php");
}
else{
	$log->LogError("Action (".$_REQUEST['action'].") is not found");
}
?>