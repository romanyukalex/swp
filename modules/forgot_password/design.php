<?php
 /****************************************************************
  * Snippet Name : change password           					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : change password form							 *
  * Access		 : include									 	 *
  ***************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
if ($_REQUEST['action']=="activate"){
	include($_SERVER["DOCUMENT_ROOT"]."/modules/forgot_password/activate.php");
} else{?>
	<div id="forgotpassblock">
	<span>Пожалуйста, введите:</span>
	<form action="/" method="post" enctype="multipart/form-data" accept-charset="utf-8" id="forgotpassform" onSubmit="saveform1('','forgotpassform','forgotpassmessage','forgot_password');return false;">
	<? if ($pageshtrih or $page){?><input type="text" value="login" name="sucpage" style="display:none" id="successpage" /><? }?>
	<p><input size="40" type="text" name="login" MAXLENGTH="40" id="login" class="text" value="Ваш Логин"  onblur="if (value == '') { value = 'Ваш Логин'}" onfocus="if (value == 'Ваш Логин') {value ='';$('#forgotpassbut').fadeIn(1000);}"></p>
	<p><span>или</span></p>
	<p><input size="40" type="text" name="contact_phone" MAXLENGTH="15" id="contact_phone" class="text" value="Номер телефона"  onblur="if (value == '') { value = 'Номер телефона'}" onfocus="if (value == 'Номер телефона') {value ='';$('#forgotpassbut').fadeIn(1000);}"></p>

	</form><br>
	<a class="large button blue" onclick="saveform('','forgotpassform','messageplace','forgot_password');return false;" id="forgotpassbut" style="display:none; width:100px">Восстановить</a>
	</div>
<? }?>
<? }?>