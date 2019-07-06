<? $log->LogInfo('Got '.(__FILE__)); ?>
<? if ($userrole=="guest" and $nitka=="1"){?><div>
<div id="loginmessage"></div>
	<fieldset class="login">
		<form method="post" action="/">
			<?if($language=="en"){?>Login<?} else {?>Имя пользователя<?}?>:<br />
			<input type="text" name="login_username" value="<?if($language=="en"){?>Put your login here<?} else {?>Введите имя пользователя<?}?>" size="30" id="formlogin" 
			onblur="if (value == '') {value = '<?if($language=="en"){?>Put your login here<?} else {?>Введите имя пользователя<?}?>'}" onFocus="if (value == '<?if($language=="en"){?>Put your login here<?} else {?>Введите имя пользователя<?}?>') {value =''}" /><br /><br />
			<?if($language=="en"){?>Password<?} else {?>Пароль<?}?>:<br />
			<input type="text" name="login_password" value="<?if($language=="en"){?>Put your password here<?} else {?>Введите пароль<?}?>" size="30" id="formpass" 
			onblur="if (value == '') {changeinputtype('#formpass','text'); value = '<?if($language=="en"){?>Put your password here<?} else {?>Введите пароль<?}?>'}" onfocus="if (value == '<?if($language=="en"){?>Put your password here<?} else {?>Введите пароль<?}?>') {value ='';changeinputtype('#formpass','password');}"	/>
			<br><br>
			<input type="image" src="/project/<?=$projectname?>/files/send_<?=$language?>.png" onclick="checkmylogin('loginmessage','cabinet');return false;">
			
		</form>
	</fieldset>
</div>
<? } else {echo $sitemessage['loginform_simple']['user_alred_logged_in'];}?>