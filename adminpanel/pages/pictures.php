<? 
/*****************************************************************************************************************************
  * Snippet Name : adminpanel:pictures.php																					 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru	from autor		 															 *
  * Purpose 	 : 											 					 *
  * Insert		 : 														 *
  ***************************************************************************************************************************/ 

if($adminpanel==1){
if($userrole=="admin" or $userrole=="root"){?>
<script type="text/javascript" src="/adminpanel/js/highslide/highslide-full.js"></script>
<link rel="stylesheet" type="text/css" href="/adminpanel/js/highslide/highslide.css" />
<script type="text/javascript">
    // override Highslide settings here
    // instead of editing the highslide.js file
    hs.graphicsDir = '/adminpanel/js/highslide/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
hs.fadeInOut = true;
hs.dimmingOpacity = 0.75;

// Add the controlbar
hs.addSlideshow({
	//slideshowGroup: 'group1',
	interval: 5000,
	repeat: false,
	useControls: false,
	fixedControls: 'fit',
	overlayOptions: {
		opacity: .75,
		position: 'bottom center',
		hideOnMouseOut: true
	}
});

</script>
	<h2>Реестр картинок</h2>
	
	
	<? $photodatareq=mysql_query("SELECT * FROM `$tableprefix-photos` WHERE 1 order by `photo_id` asc");?>
	<div id="modules_message_place"></div>
	<? if(mysql_num_rows($photodatareq)>0){?>
	<table id="settings_table" class="settings_table">
	<tr class="gradient_to_top_1" id="settings_table_header"><th width="5%">ID</th><th width="5%">Картинка</th><th width="55%">Описание картинки</th><th  width="10%">Номер галереи</th><th width="25%">Действия</th></tr>
	
	<?
	
	while($photodata=mysql_fetch_array($photodatareq)){
			?><tr class="moduletr" id="moduletr<?=$modulesdata['module_id']?>"><td class="heavy-rounded">
			<span class="hid">phototr<?=$photodata['photo_id']?></span><?
			echo $photodata['photo_id'];
			?></td>
			<td class="heavy-rounded">
			
			<div class="highslide-white">
			<a href="<?=$photodata['photo_path']?>"  class="highslide"
        onclick="return hs.expand(this,
					{wrapperClassName : 'highslide-white', spaceForCaption: 30,
					outlineType: 'rounded-white'})"><img src="<?=$photodata['photo_path']?>" width="64"></a>
			</div>

		
			</td>
			<td class="heavy-rounded"><?
			echo "<div id='fieldmessage_".$photodata['photo_id']."'></div>";
			echo $photodata['photo_title'];
			?>
			</td>
			<td class="heavy-rounded">-</td>
			<td class="barrel-rounded actiontd"><div id="changt_module_button_<?=$photodata['photo_id']?>"><a class="small button orange light-rounded" onClick="save_param('<?=$photodata['photo_id']?>','')">Настройки</a></div>
			<div id="module_data_button_<?=$modulesdata['module_id']?>"><a class="small button green light-rounded" onClick="show_photo_data('<?=$modulesdata['module_id']?>')">Информация</a></div>
			<? if($userrole=="root"){?><div id="accessbutton_<?=$modulesdata['module_id']?>"><a class="small button red light-rounded" onClick="ajaxreq('<?=$modulesdata['module_id']?>','<? if($modulesdata['enabled']=="enabled"){?>disable_module<?} else{?>enable_module<? }?>','change_param','fieldmessage_'+paramid,'adminpanel');save_param('<?=$paramdata[id]?>')"><? if($modulesdata['enabled']=="enabled"){echo "Отключить модуль";}else{echo "Включить модуль";}?></a></div><?}?>
			</td>
			</tr>
<?		
		//$prev_param_module_id=$param_module_id;
	}?>
	<tr class="hid" id="settings_table_footer"><td colspan="4" style="border:0"><span class="hid">settings_table_footer</span><a onclick="showalltr('settings_table');hidetr('settings_table','settings_table_footer',1000);return false;"><img src="/adminpanel/pics/question-type-multiple-correct256.png" class="smallimg imgmiddle">Показать все картинки</a></td></tr>
	</table><?
	} else echo "Реестр картинок пуст";
}?>
<div id="module_data_field"></div>
<? }//Нитка adminpanel?>