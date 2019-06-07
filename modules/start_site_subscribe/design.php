<?php
 /****************************************************************
  * Snippet Name : start site subscribe module 					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : some functions								 *
  * Access		 : insert_module("start_site_subscripbe");	 	 *
  ***************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){?>
<script>
function savesubsform(subscribeform,subscribeform,subscribeformmessage,startsitesubscribe){
	<? 
	$_SESSION['checksubsribeform']=rand(5,5555555);
	?>
	$('#chid').val("<?=$_SESSION['checksubsribeform']?>");
	saveform(subscribeform,subscribeform,subscribeformmessage,startsitesubscribe);
	
}
</script>
<form id="subscribeform" action="/" method="post">
	<p>
	<div id="email_input"><input type="text" size="30" id="email" name="email" value="Введите E-mail" onFocus="if(this.value=='Введите E-mail'){this.value=''};" 	onblur="if(this.value==''){this.value='Введите E-mail'};" />
	<input type="hidden" value="" name="chid" id="chid"/>
	<input type="button" id="submit_button" value="Подписаться" size="80" onclick="savesubsform('subscribeform','subscribeform','subscribeform_message','<?=$modulename?>');return false;" />
		
	</div>
	</p>
</form>
<? } ?>