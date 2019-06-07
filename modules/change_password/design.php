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
$log->LogInfo("Got ".(__FILE__));
if ($nitka=="1"){
global $pageshtrih,$page, $userrole;
if($userrole!=="guest" and $userrole){
?>
<div id="chpassmessage"></div><? // Вставить это там, где надо выводить месседж о смене пароля?>

<form action="/" method="post" enctype="multipart/form-data" accept-charset="utf-8" id="changepassform">
<b>Изменить пароль</b>
<br><p><input type="text" value="1" name="changepassmode" style="display:none" id="changepassmode" />
<input type="text" value="" name="userid" style="display:none" id="cpuserid" />
<? if ($pageshtrih or $page){?><input type="text" value="<?if($pageshtrih) echo $pageshtrih; else echo $page;?>" name="sucpage" style="display:none" id="successpage" /><? }?>
<input size="40" type="text" name="old_password" MAXLENGTH="<?=$passmaxletter?>" id="old_password" class="text" value="Текущий пароль"  onblur="if (value == '') {changeinputtype('#old_password','text'); value = 'Текущий пароль'}" onfocus="if (value == 'Текущий пароль') {value ='';changeinputtype('#old_password','password');$('#settingsbut').hide(1000);$('#changepassbut').show(1000);}"></p>
<br><p>
<input size="40" type="text" name="new_password1" MAXLENGTH="<?=$passmaxletter?>" id="new_password1" class="text"  value="Новый пароль"  onblur="if (value == '') {changeinputtype('#new_password1','text'); value = 'Новый пароль'}" onfocus="if (value == 'Новый пароль') {value ='';changeinputtype('#new_password1','password');$('#settingsbut').hide(1000);$('#changepassbut').show(1000);}"></p>
<br><p>
<input size="40" type="text" name="new_password2" MAXLENGTH="<?=$passmaxletter?>" id="new_password2" class="text"  value="Повторить новый пароль"  onblur="if (value == '') {changeinputtype('#new_password2','text'); value = 'Повторить новый пароль'}" onfocus="if (value == 'Повторить новый пароль') {value ='';changeinputtype('#new_password2','password');$('#settingsbut').hide(1000);$('#changepassbut').show(1000);}"></p>
<br>
<? if($projectname=="tscloud"){?>
<input type="image" src="/project/tscloud/files/send.png" onclick="changepass();return false;" id="changepassbut">
<? }?>
</form>
<? if($projectname!=="tscloud"){?>
<a class="large button blue" onclick="changepass();return false;" id="changepassbut" style="display:none; width:75px">Сохранить</a>
<? }?>
<!--script type="text/javascript" src="/js/md5.js"></script-->
<script>
function changepass(){
	var op = document.getElementById('old_password');
	var np1 = document.getElementById('new_password1');
	var np2 = document.getElementById('new_password2');
	<? if ($pageshtrih or $page){?>var sucpage=document.getElementById('successpage');<? }?>
	var change_pass_mode=document.getElementById('changepassmode');
	var user_id=document.getElementById('cpuserid');
	if (np1.value!=np2.value){$('#chpassmessage').html("<p style='color:red'><?=$sitemessage["$modulename"]["new_passes_not_equal"];?></p>");}
	else{
		opmd5=MD5_hexhash(op.value);
		np1md5=MD5_hexhash(np1.value);
		np2md5=MD5_hexhash(np2.value);
		$('#chpassmessage').load('/core/ajaxapi.php', {old_password:opmd5,new_password1:np1md5,new_password2:np2md5,mod:"change_password",successpage:sucpage.value,changepassmode:change_pass_mode.value,userid:user_id.value});
		}
}
function clearchangeform(){
var op = document.getElementById('old_password');var np1 = document.getElementById('new_password1');var np2 = document.getElementById('new_password2');changeinputtype('#old_password','text');changeinputtype('#new_password1','text');changeinputtype('#new_password2','text');op.value="Текущий пароль";np1.value="Новый пароль";np2.value="Повторить новый пароль";
}
</script>
<? } else echo $sitemessage["system"]["you_have_no_privileges_to_see"]." (chpass1)";// check userrole
} // nitka ?>