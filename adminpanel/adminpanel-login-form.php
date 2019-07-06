<? 
/*****************************************************************************************************************************
  * Snippet Name : adminpanel-login-form.php																				 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Форма авторизации в администраторский Веб-кабинет									 					 *
  * Insert		 : include_once('adminpanel-login-form.php');																 *
  ***************************************************************************************************************************/ 
$log->LogInfo('Got this file');
if (($userrole=='guest' or !$userrole) and $adminpanel==1){?>
<style>
html,body{height:100%;}
input{width:50%;}
form {background:#f7f7f7;border:1px solid #ddd;
padding: 30px 30px 0px 30px;
}
</style>
<script type="text/javascript" src="/js/md5.js"></script>
<script type="text/javascript">

function encode_pass() {
  var dp = document.getElementById('dummy_password');
  var rp = document.getElementById('real_password');
  rp.value = MD5_hexhash(dp.value);
  dp.value = '';
};
/*
$(document).ready(function(){
		$("#login").focus().wait(1000);
		
		$("#dummy_password").focus();
		//$("#btn").focus();
})*/
</script>

<div class="wrapper container center-block h-100 w-100" style="background:#FFF;">
	<div  class="row flex-items-md-middle flex-items-sm-center h-100 mx-auto">
		
		<div class="col-md-12 col-lg-5 col-xs-12 col-sm-12 hidden-md-down">
			<a href="/" class="pull-right hidden-md-down"><img <?
					if(file_exists($_SERVER['DOCUMENT_ROOT']."/project/".$projectname.$adminlogofile)){
						?>src='/project/<?=$projectname.$adminlogofile?>'<?
					} else {?> src="/files/shoes/Shoe512_yellow.png"<? }
					?> height="200px" border="0"></a>
		</div>
		<div class="col-lg-5 col-md-12 col-xs-12 col-sm-12">
			<div class="row  hidden-lg-up flex-items-md-center">
			<a href="/" class=" hidden-lg-up"><img <?
					if(file_exists($_SERVER['DOCUMENT_ROOT']."/project/".$projectname.$adminlogofile)){
						?>src='/project/<?=$projectname.$adminlogofile?>'<?
					} else {?> src="/files/shoes/Shoe512_yellow.png"<? }
					?> height="200px" border="0"></a>
			</div>
			<FORM ACTION="/adminpanel/" METHOD="POST" id=info onsubmit="encode_pass()" class="w-100 h-100 pull-left">
			<? if ($errmessage){echo "<span style='font:6;'>".$errmessage."</span><br>";}; ?>
			
			<?/*
			<div id="login-wrap" class="slider">
			<label for="login">Логин</label>
			<INPUT TYPE="text" NAME="login" ID="login" MAXLENGTH="20" class="form-control form-control-lg">
			</div>
			
			<br><br>
			<div id="password-wrap" class="slider">
			<label for="dummy">Пароль</label>
			<input type="password" name="dummy" id="dummy_password" value="" MAXLENGTH="20" class="form-control form-control-lg" /><br />
			<input type="hidden" name="password" id="real_password" value="" />
			</div><br>
			*/?>
			
	
			
					
			<div class="form-group row">
				<label for="login" class="col-sm-2 col-form-label">Логин</label>
				<div class="col-sm-10">
				  <INPUT TYPE="text" NAME="login" ID="login" MAXLENGTH="20" class="form-control form-control-lg" placeholder="Логин">
				</div>
			</div>
			
			
			<div class="form-group row">
				<label for="dummy_password" class="col-sm-2 col-form-label">Пароль</label>
				<div class="col-sm-10">
				  <input type="password" name="dummy" id="dummy_password" class="form-control form-control-lg" placeholder="Пароль">
				  <input type="hidden" name="password" id="real_password" value="" />
				</div>
			</div>
			
			
			<div class="form-group row  hidden-md-down">
			  <div class="offset-sm-2 col-sm-10">
				<button type="submit" class="btn btn-primary" id="btn">Войти</button>
				
			  </div>
			</div>
			<div class="form-group row  hidden-lg-up flex-items-md-center form-control-lg">
			  <div class="col-sm-3">
				<button type="submit" class="btn btn-primary btn-block" id="btn">Войти</button>
			  </div>
			</div>
			
			
			
			<INPUT type="text" SIZE="1" MAXLENGTH="1" name="Family" class="hid">
			<?/*<INPUT type="submit" value="Войти" id="btn" name="btn">*/?>
			
			</FORM>
			
		</div>
	</div>
</div>
<? } ?>