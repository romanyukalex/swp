<? 
/************************************************************************************
* Snippet Name : adminpanel-checkuserrole.php										*															
* Scripted By  : RomanyukAlex		           										*														
* Website      : http://popwebstudio.ru	   											*				 
* Email        : admin@popwebstudio.ru    					 						* 
* License      : License on popwebstudio.ru from autor		 						*
* Purpose 	 : Процесс аутентификации юзера администраторского веб-интерфеса		*
* Insert		 : include_once('adminpanel-checkuserrole.php');					*  
************************************************************************************/
$log->LogInfo('Got this file');
if($adminpanel==1){
?>
<div id='messagestable'>
<h1><img src="/adminpanel/pics/NotificationTemplates256.png"  height="64px" class="imgmiddle">Системные сообщения</h1><br>
<table id="messages_table" class="settings_table">
	<tr class="gradient_to_top_1"><th width="25%">Описание сообщения</th><th width="60%">Текст</th><th width="15%">Действия</th></tr>
	<?
	# Границы выбора
	if($moduleid){#Выбирают настройки модуля
		$meswhere="`module_id`='$moduleid'";
	} else $meswhere="1";
	
	$messagesdatareq=mysql_query("SELECT * FROM `$tableprefix-messages` WHERE $meswhere order by `module_name` asc, `message_id` asc;");
	while($avmodulesresult=mysql_fetch_array($avmodulesqry)){$moduledescription[$avmodulesresult['modulename']]=$avmodulesresult['module_description'];}
	if(@mysql_num_rows($messagesdatareq)>0){
		while($messagesdata=mysql_fetch_array($messagesdatareq)){
			$messages_module_id=$messagesdata['module_name'];
			if($messages_module_id!==$prev_messages_module_id){ # Пошли настройки нового модуля
				$moduleinfo=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-modulesregister` WHERE `module_id`='$messages_module_id'"));
			}
			
				?><tr><td  class="barrel-rounded">
				<? if($moduledescription[$messages_module_id]){?>
				<b style="font-size:11px"><?=$moduledescription[$messages_module_id];?></b><br><?} 
				echo $messagesdata['message_meaning'];?></td>
				<td class="heavy-rounded valuestd"><div id='upd_message_<?=$messagesdata['message_id']?>_ap'></div>
				<form id="upd_message_form_<?=$messagesdata['message_id']?>">
				RU : <input type='text' SIZE='<?=$formsize_standart?>' MAXLENGTH="<?=$messagesdata['formmaxlegth']?>" 
				name='message_ru' value="<?=$messagesdata['message_ru']?>" 
				onFocus="showblock('mes_savebutton_<?=$messagesdata['message_id']?>');return false;" 
				id='message_ru_<?=$messagesdata['message_id']?>'><br>
				EN : <input type='text' SIZE='<?=$formsize_standart?>' MAXLENGTH="<?=$messagesdata['formmaxlegth']?>" 
				name='message_en' value="<?=$messagesdata['message_en']?>" 
				onFocus="showblock('mes_savebutton_<?=$messagesdata['message_id']?>');return false;" 
				id='message_en_<?=$messagesdata['message_id']?>'><br>
				</form>
				<?if($userrole=="root"){
						?><br>Вызов: <input value="echo $sitemessage[<?=$messagesdata['module_name']?>][<?=$messagesdata['message_code']?>];" size="<?=($formsize_standart-29)?>" readonly="readonly"><?
					}
				?></td>
				<td class="barrel-rounded">&nbsp <div id="mes_savebutton_<?=$messagesdata['message_id']?>" style="display:none"><a class="large button orange light-rounded" 
					onClick="saveform2('<?=$messagesdata['message_id']?>','upd_message_form_<?=$messagesdata['message_id']?>','upd_message_<?=$messagesdata['message_id']?>_ap','adminpanel','upd_message','','');">
					Сохранить</a><br><br></div>
					<a class="large button red light-rounded" 
					onClick="ajax_rq ('adminpanel','delete_message','upd_message_<?=$messagesdata['message_id']?>_ap','upd_message_<?=$messagesdata['message_id']?>_ap','<?=$messagesdata['message_id']?>');">
					Удалить</a>
				<? /*if($userrole=="root"){?><div id="accessbutton_<?=$messagesdata['message_id']?>"><a class="small button blue light-rounded" onClick="ajaxreq('<?=$messagesdata[id]?>','<? if($messagesdata['showtositeadmin']=="2"){?>admin_access_accept<?} else{?>admin_access_deny<? }?>','change_param','fieldmessage_'+paramid,'adminpanel');save_param('<?=$messagesdata[id]?>')"><? if($messagesdata['showtositeadmin']=="2"){echo "Разрешить доступ админу";}else{echo "Запретить доступ админу";}?></a></div><?} */?>
				</td>
				</tr>
	<?		$prev_messages_module_id=$messages_module_id;
		}
		if($userrole=="root"){
			?><tr><td class="barrel-rounded">
			<b style="font-size:11px">Новое сообщение</b><br>
			<form id="new_message_form">
			Модуль : <select name="module">
			<option value="system"> </option>
			<? 
			$avmodulesqry=mysql_query("SELECT * FROM `$tableprefix-modulesregister` WHERE 1;");//два поля - modulename и installed
			if(mysql_num_rows($avmodulesqry) > '0'){
				while($avmodulesresult=mysql_fetch_array($avmodulesqry)){
				?><option value="<?=$avmodulesresult['modulename']?>"><?=$avmodulesresult['module_description']?></option><?
				}
			}?>
			</select>
			Описание : <input type="text" name="message_meaning"></td>
			<td class="heavy-rounded valuestd">
			<div id='add_new_message_ap'></div>
		
			RU : <input type='text' SIZE='<?=$formsize_standart?>' 
			name='message_ru' value="" 
			onFocus="showblock('new_mes_savebutton'); return false;"><br>
			EN : <input type='text' SIZE='<?=$formsize_standart?>' MAXLENGTH="<?=$messagesdata['formmaxlegth']?>" 
			name='message_en' value="" 
			onFocus="showblock('new_mes_savebutton');return false;"><br>
			CODE  : <input name="message_code" size="<?=($formsize_standart-3)?>" title="Произвольная фраза на латинице"><br>
			Компания  : <select name="company_id">
			<option value="-">-</option>
			<? $company_info_q=mysql_query("SELECT * FROM `$companiesprefix-companies` WHERE 1;");//два поля - modulename и installed
			if(mysql_num_rows($company_info_q) > '0'){
				while($company_info=mysql_fetch_array($company_info_q)){
					?><option value="<?=$company_info['company_id']?>"><?=$company_info['form_of_business_ownership']." ".$company_info['company_full_name']." [".$company_info['company_id']."]"?></option><?
				}
			}?>
			</select>
			</form>
			</td><td class="barrel-rounded">
				&nbsp <div id="new_mes_savebutton" style="display:none"><a class="large button orange light-rounded" onClick="saveform3('add_new_message', 'new_message_form', 'add_new_message_ap','add_new_message_ap', 'adminpanel', 'add_new_message','resetform','');
				">
					Добавить</a><br><br>
					</div>
			</td></tr><?
		}
	} else {?><tr><td class="barrel-rounded"></td><td class="heavy-rounded">Сообщения не найдены</td><td class="barrel-rounded"></td></tr><?
	}?>
</table>
</div>
<? } ?>