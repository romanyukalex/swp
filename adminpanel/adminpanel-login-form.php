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
<script type="text/javascript" src="/js/md5.js"></script>
<script type="text/javascript">
//<![CDATA[
function encode_pass() {
  var dp = document.getElementById('dummy_password');
  var rp = document.getElementById('real_password');
  rp.value = MD5_hexhash(dp.value);
  dp.value = '';
};
//]]>

$(document).ready(function(){
		$("#login").focus();
		$("#dummy_password").focus();
		$("#real_password").focus();
})
</script>


<div  class="row flex-items-md-middle" style="background:#FFF; height:100%">
	
	
	<div class="col-md-12 col-xs-12" id="errormessage"><? if($errmessage) echo $errmessage;?></div>
	
	<div class="col-md-6">
		<a href="/"><img <?
				if(file_exists($_SERVER['DOCUMENT_ROOT']."/project/".$projectname.$adminlogofile)){
					?>src='/project/<?=$projectname.$adminlogofile?>'<?
				} else {?> src="/files/shoes/Shoe512_yellow.png"<? }
				?> height="200px" border="0"></a>
	</div>
	
	<div class="col-md-6">
	
		<FORM ACTION="/adminpanel/" METHOD="POST" id=info onsubmit="encode_pass()">
		<? if ($errmessage){echo "<span style='font:6;'>".$errmessage."</span><br>";}; ?>
		<div id="login-wrap" class="slider">
		<label for="login">Логин</label>
		<INPUT TYPE="text" NAME="login" ID="login" MAXLENGTH="20" style="height:30;">
		</div><br><br>
		<div id="password-wrap" class="slider">
		<label for="dummy">Пароль</label>
		<input type="password" name="dummy" id="dummy_password" value="" MAXLENGTH="20" style="height:30;" /><br />
		<input type="hidden" name="password" id="real_password" value="" />
		</div><br>
		<INPUT type="text" SIZE="1" MAXLENGTH="1" name="Family" class="hid">
		<INPUT type="submit" value="Войти" id="btn" name="btn">
		</FORM>
		
	</div>
</div>
<? } ?>