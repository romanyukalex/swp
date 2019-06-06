<? 
/*****************************************************************************************************************************
  * Snippet Name : adminpanel-settings.php																					 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru	from autor		 															 *
  * Purpose 	 : Скрипт обработки изменений настроек сайта											 					 *
  * Insert		 : include_once('Adminpanel-siteconfig_Creator.php');														 *
  ***************************************************************************************************************************/ 
if($adminpanel==1){
if($userrole=="admin" or $userrole=="root"){?>
	
	<h2>Установленные модули</h2>
	<div id="modules_message_place"></div>
	<table id="module_table" class="settings_table">
	<tr class="gradient_to_top_1" id="settings_table_header"><th width="5%">ID</th><th width="55%">Описание модуля</th><th  width="15%">Дата установки</th><th width="25%">Действия</th></tr>
	
	<?
	$modulesdatareq=mysql_query("SELECT * FROM `$tableprefix-modulesregister` WHERE 1 order by `module_id` asc");
	while($modulesdata=mysql_fetch_array($modulesdatareq)){
			?><tr class="moduletr" id="moduletr<?=$modulesdata['module_id']?>"><td class="heavy-rounded">
			<span class="hid">moduletr<?=$modulesdata['module_id']?>_</span><?
			echo $modulesdata['module_id'];
			?></td><td class="heavy-rounded"><?
			echo "<div id='fieldmessage_".$modulesdata['module_id']."'></div>";
			echo $modulesdata['module_description'];
			?>
			</td>
			<td class="heavy-rounded"><?=$modulesdata['install_ts']?></td>
			<td class="barrel-rounded actiontd"><div id="changt_module_button_<?=$modulesdata['module_id']?>"><a class="small button orange light-rounded" onClick="show_module_data('<?=$modulesdata['module_id']?>','<?=$modulesdata['modulename']?>','show_module_settings','module_data_field')">Настройки</a></div>
			<div id="module_data_button_<?=$modulesdata['module_id']?>"><a class="small button green light-rounded" onClick="show_module_data('<?=$modulesdata['module_id']?>','<?=$modulesdata['modulename']?>','show_module_data','module_data_field')">Данные</a></div>
			<? if($userrole=="root"){?><div id="accessbutton_<?=$modulesdata['module_id']?>"><a class="small button red light-rounded" onClick="ajaxreq('<?=$modulesdata['module_id']?>','<? if($modulesdata['enabled']=="enabled"){?>disable_module<?} else{?>enable_module<? }?>','change_param','fieldmessage_'+paramid,'adminpanel');save_param('<?=$paramdata[id]?>')"><? if($modulesdata['enabled']=="enabled"){echo "Отключить модуль";}else{echo "Включить модуль";}?></a></div><?}?>
			</td>
			</tr>
<?		
		$prev_param_module_id=$param_module_id;
	}?>
	<tr id="all_modules_tr"><td colspan="4" style="border:0"><span class="hid">settings_table_footer</span>
	<a onclick="ajax_rq ('adminpanel','get_unistalled_modules','all_modules_tr','all_modules_tr');return false;"><img src="/adminpanel/pics/Mahjong256.png" class="smallimg imgmiddle">Показать все доступные модули</a></td></tr>
	<tr class="hid" id="settings_table_footer"><td colspan="4" style="border:0"><span class="hid">settings_table_footer</span>
	<a onclick="showalltr('module_table');hidetr('module_table','settings_table_footer',1000);return false;"><img src="/adminpanel/pics/question-type-multiple-correct256.png" class="smallimg imgmiddle">Показать все модули</a></td></tr>
	</table><?
}?>
<div id="module_data_field"></div><br><br>
<? }//Нитка adminpanel?>