<?php
 /****************************************************************
  * Snippet Name : contact_form		          					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : contact_form design							 *
  * Access		 : include, insert_module					 	 *
  ***************************************************************/
$log->LogDebug("Got this file");
if ($nitka=="1"){
?>
<div id="cf_messageplace"></div>
<div id="contact_form">
 	<div class="window-border">
		<div class="window-wrap">
			<div id="regform_answerplace"></div>
		   <form method="post" name="contact" action="/" onsubmit="saveform('<?=rand(1,99999999)?>','contact_mailform','cf_messageplace','contact_form');return false;" id="contact_mailform">

		 
		
			<table class="b-simple-form b-simple-form_with-required" style="width:75%">
			  <tbody><tr>
				<td class="label required">
				  <label><? if($language=="en"){?>Your name<?} else {?>Имя:<?}?></label>
				</td>
				<td class="field">
				  <span class="text-field">
					<b></b>
					 <input type="text" id="author" name="author" required="required" />
				  </span>
				</td>
			  </tr>
			  <tr>
				<td class="label required">
				  <label>E-mail</label>
				</td>
				<td class="field">
				  <span class="text-field">
					<b></b>
					 <input type="email" id="email" name="email" required="required"/>
				  </span>
				</td>
			  </tr>
			  <tr>
				<td class="label required">
				  <label><? if($language=="en"){?>Message text<?} else {?>Сообщение:<?}?></label>
				</td>
				<td class="field">
				  
					<textarea id="text" name="mailtext" rows="5" required="required" style="resize: none;border: none;padding: 5px 10px 10px 5px; border:1px solid #000" class="textarea"></textarea>
				
				</td>
			  </tr>
			</tbody></table>
			 
			<div>
			
			<a class="large button green"onclick="saveform('<?=rand(1,99999999)?>','contact_mailform','cf_messageplace','contact_form');return false;"><? if($language=="en"){?>SEND<?} else ?>Отправить</a>
			  <span style="display:none" class="error"><? if($language=="en"){?>Check all required fields<?} else {?>Проверьте правильность заполнения обязательных полей<?}?></span>
			</div>
		  </form>
		</div>
	</div>
</div>
<? } ?>