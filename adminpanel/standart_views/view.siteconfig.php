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
<div id='settingstablediv'>
				<h1><img src="/adminpanel/pics/checklist256.png" height="64px" class="imgmiddle">Параметры системы!</h1><br>
			
<table id="settings_table" class="settings_table">
	<tr class="gradient_to_top_1"><th width="25%">Описание параметра</th><th width="60%">Значение параметра</th><th width="15%">Действия</th></tr>
	<?
	# Границы выбора
	if($moduleid){#Выбирают настройки модуля
		$paramwhere="`module_id`='$moduleid'";
	} else $paramwhere="1";
	$paramdatareq=mysql_query("SELECT * FROM `$tableprefix-siteconfig` WHERE $paramwhere order by `module_id` asc, `id` asc;");
	if(mysql_num_rows($paramdatareq)>0){
		while($paramdata=mysql_fetch_array($paramdatareq)){
			$param_module_id=$paramdata['module_id'];
			if($param_module_id!==$prev_param_module_id){ # Пошли настройки нового модуля
				$moduleinfo=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-modulesregister` WHERE `module_id`='$param_module_id'"));
				//echo "ЭТО НАСТРОЙКИ МОДУЛЯ ".$moduleinfo['module_description'];
			}
			
			if ($paramdata['showtositeadmin']=="1" or $userrole=="root"){# Вывод параметра для правки
				?><tr><td  class="barrel-rounded"><?
				if ($paramdata['showtositeadmin']=="2" and $userrole=="root"){echo "<b>*</b>";}
				echo $paramdata['describe'];
				?></td><td   class="heavy-rounded"><?
				echo "<div id='fieldmessage_".$paramdata['id']."'></div>";
				if($paramdata['vartype']=="1"){// Это input
					?><input type='text' SIZE='<?=$formsize_standart?>' MAXLENGTH="<?=$paramdata['formmaxlegth']?>" name='<?=$paramdata['id']?>' value="<?=$paramdata['value']?>" onFocus="showblock('sc_savebutton_<?=$paramdata['id']?>');return false;" id='field_<?=$paramdata['id']?>'><?
				}
				elseif ($paramdata['vartype']=="2"){// Это select
					$options = explode(";;",$paramdata['varpossible']);
					echo "<SELECT NAME='".$paramdata['id']."' onchange='showblock(\"sc_savebutton_".$paramdata['id']."\")' id='field_".$paramdata['id']."'>";
					foreach ($options as $option)
						{echo "<OPTION VALUE='".$option."'";
						if ($option==$paramdata['value']){echo " selected";}
						echo ">".$option."</OPTION>";
						}
					echo "</SELECT>";
				}
				elseif($paramdata['vartype']=="3"){// Это Checkbox
					?><div class='block' onMouseover="showblock('sc_savebutton_<?=$paramdata['id']?>');return false;">
					<input type="checkbox"  value="true" name="<?=$paramdata['id']?>" onChange="showblock('savebutton_<?=$paramdata['id']?>');return false;" id='field_<?=$paramdata['id']?>'<? if ($paramdata['value']=="true"){?>checked="checked"<?}?> />
				<?	}
				elseif($paramdata['vartype']=="4"){// Это цвет
					echo "<input type='text' MAXLENGTH=".$formmaxlegth." name='".$paramdata['id']."' value="."\"".$paramdata['value'].
					"\" onFocus=\"showblock('sc_savebutton_".$paramdata['id']."');return false;\" id='color".$paramdata['id']."'>";
					echo "<br><div id='picker".$paramdata['id']."'></div>"; ?>
					<script type="text/javascript" charset="utf-8">$(document).ready(function() {$('#picker<?=$paramdata['id'];?>').farbtastic('#color<?=$paramdata['id'];?>');});</script>					
			<?	}
				if ($paramdata['example']){
					?><br><a onclick="showblock('var_<?=$paramdata['id']?>');return false;" href="" class='menuA'>Пример заполнения</a>
					<div class="heavy-rounded example" id='var_<?=$paramdata['id']?>'>
					<?=$paramdata['example']?></div><?
				}
				if($userrole=="root"){//echo "<br>Переменная - $".$paramdata['systemparamname'];
						?><br>Название переменной: <input value="$<?=$paramdata['systemparamname']?>" size="<?=($formsize_standart-29)?>" readonly="readonly"><?
					}
				?></td>
				<td class="barrel-rounded">&nbsp <div id="sc_savebutton_<?=$paramdata['id']?>" style="display:none">
				<a class="large button orange light-rounded" onClick="save_param('<?=$paramdata[id]?>','<?=$paramdata['vartype']?>')">Сохранить</a><br><br></div>
				<? if($userrole=="root"){?><div id="accessbutton_<?=$paramdata['id']?>"><a class="small button blue light-rounded" onClick="ajaxreq('<?=$paramdata[id]?>','<? if($paramdata['showtositeadmin']=="2"){?>admin_access_accept<?} else{?>admin_access_deny<? }?>','change_param','fieldmessage_'+paramid,'adminpanel');save_param('<?=$paramdata[id]?>')"><? if($paramdata['showtositeadmin']=="2"){echo "Разрешить доступ админу";}else{echo "Запретить доступ админу";}?></a></div><?}?>
				</td>
				</tr>
	<?		}
			$prev_param_module_id=$param_module_id;
		}
	} else{?><tr><td class="barrel-rounded"></td><td class="heavy-rounded">Настройки не найдены</td><td class="barrel-rounded"></td></tr><?}?>
</table>



<?
if($userrole=="root"){?>
			<a onClick="showHideSelectionSoft('addnewparam',1000)" id="addnewparamlink">
				<img src="/adminpanel/pics/green-add-circle.png" height="64px" class="imgmiddle">Добавить новый параметр</a><br>
			
			<div style='display: none;' id='addnewparam'>
			<br>
			<? include($_SERVER['DOCUMENT_ROOT']."/adminpanel/adminpanel-siteconfig_creator.php");?><br><br><br>
			<br><br><br></div>
			<? }
			
			?><br><br><br>
			</div>
<? } else $log->LogError('Adminpanel param is not exist');?>