<? # get_newuser_table();
global $log;
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
?>
<div id="createuserform_message_place"></div>
<form id="createuserform">
<table><tbody><tr><td width="200px">Имя пользователя</td><td width="30px"><b>:</b></td><td><input name="userfullname" type="text" size="50"></td></tr>
<tr><td>Электронная почта</td><td><b>:</b></td><td><input name="usercontactmail" type="text" size="50"></td></tr>
<tr><td>Пароль</td><td><b>:</b></td><td><select name="userpasswordtype" style="width:322px" onchange="check_email_field()" id="userpasswordtypesel"><option value="1">По-умолчанию</option><option value="2">Задать вручную:</option></select>
<input name="userpassword1"type="text" id="dummy_password"  size="50" style="display:none" value="Введите пароль" onblur="if (value == '') {changeinputtype('#dummy_password','text'); value = 'Введите пароль'}" onfocus="if (value == 'Введите пароль') {value ='';changeinputtype('#dummy_password','password');}">
<input name="userpassword" type="hidden"   id="real_password" value="" />
</td></tr>
<tr><td>После создания аккаунта</td><td><b>:</b></td><td>
<input type="radio" name="activationpath" value="sendletter" checked>Прислать письмо со ссылкой для активации<Br>
<input type="radio" name="activationpath" value="activate">Активировать без подтверждения<Br>
<input type="checkbox" name="chpassmust" value="2" id="chpassmustinput" checked disabled>Пользователь должен сменить пароль<br>
</td></tr>
<tr><td colspan="3">
<? if($projectname=="tscloud"){?>
<input type="image" onclick="sendformwithpass(); return false;" src="/project/tscloud/files/send.png">
<? } else{
?>
<a onclick="sendformwithpass(); return false;" class="large button green light-rounded">Создать</a>
<?}?>
</td></tr>
</tbody></table></form>
<script>
function sendformwithpass(){
	rp = document.getElementById('formpass');
	 var dp = document.getElementById('dummy_password');
	var rp = document.getElementById('real_password');
	rp.value = MD5_hexhash(dp.value);
	dp.value = '';
	saveform('create_user','createuserform','createuserform_message_place','');
}
function check_email_field(){
	var userpasswordtype=$("#userpasswordtypesel").val();
	if(userpasswordtype=="1"){$("#dummy_password").fadeOut();
	$("#chpassmustinput").attr('checked','checked').attr('disabled','disabled');
	}
	else if(userpasswordtype=="2"){$("#dummy_password").fadeIn();
	$("#chpassmustinput").attr('disabled','');
	}
}
</script>