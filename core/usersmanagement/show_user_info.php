<? #Вынести в project воблы
$log->LogInfo('Got this file');
//if($userrole and $userrole!=="guest"){ 
insert_function("getAge");?>
<div class="b-other-projects b-text mb">
	<div class="wrap">                 
	<div class="b-text_2col">

	
<table>
<? if($user_avatar) {?>
	<tr><td width="200px">Аватар в соц.сети</td><td width="30px"><b>:</b></td><td><img src="<?=$user_avatar;?>"></td></tr>
<?	
}

if ($fullname){ ?>
<tr><td width="200px">Имя пользователя</td><td width="30px"><b>:</b></td><td> <?=$fullname;?></td></tr>
<?}
if($nickname) {?>
	<tr><td>Никнейм</td><td><b>:</b></td><td><?=$nickname?></td></tr>
<?}?>
<tr><td>Логин</td><td><b>:</b></td><td><?=$login?></td></tr>

<?if($_SESSION['user_data']['second_name']) {?>
	<tr><td>Фамилия</td><td><b>:</b></td><td><?=$_SESSION['user_data']['second_name']?>
	<? /*<input name="second_name" value="<?=$_SESSION['user_data']['second_name']?>" id="fullnamefield<?=$_SESSION['user_data']['userid']?>" size="50">*/?>
	
	</td></tr>
	<tr><td>Имя</td><td><b>:</b></td><td>
	<?=$_SESSION['user_data']['first_name']?>
	<? /*<input name="first_name" value="<?=$_SESSION['user_data']['first_name']?>" id="firstnamefield<?=$_SESSION['user_data']['userid']?>" size="50">*/?>
	</td></tr>
	<tr><td>Отчество</td><td><b>:</b></td><td>
	<?=$_SESSION['user_data']['patronymic_name']?>
	<? /*<input name="patronymic_name" value="<?=$_SESSION['user_data']['patronymic_name']?>" id="patronymicnamefield<?=$_SESSION['user_data']['userid']?>" size="50">*/?>
	</td></tr>
	<?
}
if($_SESSION['user_data']['gender']){?>
<tr><td>Пол</td><td><b>:</b></td><td>
	<?
	if($_SESSION['user_data']['gender']=="male"){?><img src="/adminpanel/pics/Male256.png" width="32px"><?}
	elseif($_SESSION['user_data']['gender']=="female"){?><img src="/adminpanel/pics/Female256.png" width="32px"><?}
	else{?>-<?}
	/*
	<img src="/adminpanel/pics/Male256.png" width="32px"><input type="radio" name="gender" id="genderfield<?=$_SESSION['user_data']['userid']?>" value="male"<?if($_SESSION['user_data']['gender']=="male") echo "checked";?>>
	<img src="/adminpanel/pics/Female256.png" width="32px"><input type="radio" name="gender" id="genderfield<?=$_SESSION['user_data']['userid']?>" value="female"<?if($_SESSION['user_data']['gender']=="female") echo "checked";?>>
	<img src="/adminpanel/pics/question-type-true-false256.png" width="32px"><input type="radio" name="gender" id="genderfield<?=$_SESSION['user_data']['userid']?>" value="-"<?if($_SESSION['user_data']['gender']=="-") echo "checked";?>>
	*/?>
	</td></tr>
<?}?>

	
<tr><td>ДР</td><td><b>:</b></td><td>

<? if ($_SESSION['user_data']['birthdate'] and $_SESSION['user_data']['birthdate']!=="0000-00-00") echo $_SESSION['user_data']['birthdate'];
	
	/*<input name="birthdate" value="<? if ($_SESSION['user_data']['birthdate'] and $_SESSION['user_data']['birthdate']!=="0000-00-00") echo $_SESSION['user_data']['birthdate'];?>" id="birthdatefield<?=$_SESSION['user_data']['userid']?>" size="50">
	*/?>
	<? if($_SESSION['user_data']['birthdate'] and $_SESSION['user_data']['birthdate']!=="0000-00-00"){echo "<br>( Полных лет: ".getAge($_SESSION['user_data']['birthdate'])." )";
}?></td></tr>

<tr><td>Электронная почта</td><td><b>:</b></td><td> <?=$_SESSION['user_data']['contactmail'];
/*<input name="contactmail" value="<?=$_SESSION['user_data']['contactmail']?>" id="contactmailfield<?=$_SESSION['user_data']['userid']?>" size="50">*/?>

</td></tr>
<tr><td>Телефон</td><td><b>:</b></td><td><?=$_SESSION['user_data']['contact_phone'];

 /*<input name="contact_phone" value="<?=$_SESSION['user_data']['contact_phone']?>" id="contactmailfield<?=$_SESSION['user_data']['userid']?>" size="50">*/?>

</td></tr>
<tr><td>СоглОбрПерсДанных</td><td><b>:</b></td><td>
	<input type="checkbox" name="is_allowed_personal" id="is_allowed_personalfield<?=$_SESSION['user_data']['userid']?>"<?if($_SESSION['user_data']['is_allowed_personal']){?> checked<?}?> onclick="return false;">
</td></tr>

<?
 if($userrole=="user" and ($companyinfo['company_id'] or $company_id)){?>
	<tr><td>Компания</td><td><b>:</b></td><td title="<?=$companyinfo['company_id']?>"><?=$companyinfo['form_of_business_ownership']." ".$companyinfo['company_full_name']?></td></tr>
 <? }?>

</table></div></div></div>



<? if($userrole=="superuser"){?>
<div class="b-other-projects b-text mb">
	<div class="wrap">                 
	<div class="b-text_2col">
	<table>
<tr><td width="200px">Компания</td><td width="30px"><b>:</b></td><td title="<?=$companyinfo['company_id']?>"><?=$companyinfo['form_of_business_ownership']." ".$companyinfo['company_full_name']?></td></tr>
<? if($companyinfo['inn']){?><tr><td>ИНН</td><td><b>:</b></td><td><?=$companyinfo['inn']?></td></tr><? }
if($companyinfo['kpp']){?><tr><td>КПП</td><td><b>:</b></td><td><?=$companyinfo['kpp']?></td></tr><? }
if($companyinfo['bik']){?><tr><td>КПП</td><td><b>:</b></td><td><?=$companyinfo['bik']?></td></tr><? }
if($companyinfo['legal_address']){?><tr><td>Юридический адрес</td><td><b>:</b></td><td><?=$companyinfo['legal_address']?></td></tr><? }
if($companyinfo['real_address']){?><tr><td>Фактический адрес</td><td><b>:</b></td><td><?=$companyinfo['real_address']?></td></tr><? }
if($companyinfo['post_address']){?><tr><td>Почтовый адрес</td><td><b>:</b></td><td><?=$companyinfo['post_address']?></td></tr><? }
if($companyinfo['company_domain']){?><tr><td>Сайт компании</td><td><b>:</b></td><td><?=$companyinfo['company_domain']?></td></tr><? }
?>
</table>
</div></div></div>
<? }// Данные для суперюзеров
?><br><br><br>
<? /*}else{?><script>changerazdel("login");</script><?}*/