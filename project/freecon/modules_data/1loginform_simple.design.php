<? $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__)); ?>
<?if (($userrole=="guest" or !$userrole) and $nitka=="1"){?><div>
<form action="/login/" method="POST" class="direct" data-form="login">
	<div class="popup__error"></div>
	<div id="loginmessage"></div>
	<div class="item">
		<div class="label">E-mail</div>
		<input class="input" name="login_username" type="text" placeholder="Введите ваш e-mail" value="">
		<div class="input-error"></div>
	</div>

	<div class="item">
		<div class="label">Пароль</div>
		<input class="input"  name="login_password" type="password" placeholder="Введите ваш пароль" value="">
		<div class="input-error"></div>
	</div>

	<a class="green-button submit js-form-submit" onClick="checkmylogin();return false;">
		<span class="text">Войти</span>
		<span class="loading"></span>
	</a>

	<input class="hidden" type="submit">

</form>
<? }?>