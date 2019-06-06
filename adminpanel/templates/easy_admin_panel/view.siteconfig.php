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
<div id="page-wrapper">
<div class="graphs">
<h3 class="blank1"><img src="/adminpanel/pics/checklist256.png" height="64px" class="imgmiddle">Параметры системы</h3>


<div class="panel panel-warning" data-widget-static="" data-widget="{"draggable": "false"}">
<div class="panel-body no-padding ">
								<table class="table table-striped">
									<thead>
										<tr class="warning">
											
											<th class="col-md-4">Описание параметра</th>
											<th class="col-md-6">Значение параметра</th>
											<th class="col-md-2">Действия</th>
										</tr>
									</thead>
									<tbody>
	<?
	
	
	if(mysql_num_rows($paramdatareq)>0){
		$paramnum=0;//Номер строки для очередности цвета
		while($paramdata=mysql_fetch_array($paramdatareq)){
			$paramnum++;
			$param_module_id=$paramdata['module_id'];
			if($param_module_id!==$prev_param_module_id){ # Пошли настройки нового модуля
				$moduleinfo=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-modulesregister` WHERE `module_id`='$param_module_id'"));
			}
			
			if ($paramdata['showtositeadmin']=="1" or $userrole=="root"){# Вывод параметра для правки
			?><tr><td><?
				if ($paramdata['showtositeadmin']=="2" and $userrole=="root"){echo "<b>*</b>";}
				echo $paramdata['describe'];
				?></td><td><div id='fieldmessage_<?=$paramdata['id']?>'></div>
				<?if($paramdata['vartype']=="1"){// Это input
					?>					
					<input class="form-control1" type='text' MAXLENGTH="<?=$paramdata['formmaxlegth']?>" name='<?=$paramdata['id']?>' value="<?=$paramdata['value']?>" onFocus="showblock('sc_savebutton_<?=$paramdata['id']?>');return false;" id='field_<?=$paramdata['id']?>'>
					<?
				}
				elseif ($paramdata['vartype']=="2"){// Это select
					$options = explode(";;",$paramdata['varpossible']);
					?><SELECT class="form-control1" NAME='<?=$paramdata['id']?>' onchange='showblock("sc_savebutton_<?=$paramdata['id']?>")' id='field_<?=$paramdata['id']?>'><?
					foreach ($options as $option)
						{echo "<OPTION VALUE='".$option."'";
						if ($option==$paramdata['value']){echo " selected";}
						echo ">".$option."</OPTION>";
						}
					echo "</SELECT>";
				}
				elseif($paramdata['vartype']=="3"){// Это Checkbox?>
				<div class="checkbox-inline1" onMouseover="showblock('sc_savebutton_<?=$paramdata['id']?>');return false;">
					<label>
					<input type="checkbox"value="true" name="<?=$paramdata['id']?>" onChange="showblock('savebutton_<?=$paramdata['id']?>');return false;" id='field_<?=$paramdata['id']?>'<? if ($paramdata['value']=="true"){?>checked="checked"<?}?>>
					</label>
				</div>
				
				<?	}
				elseif($paramdata['vartype']=="4"){// Это цвет
					?><input type='text' name='<?=$paramdata['id']?>' value="<?=$paramdata['value']?>" onFocus="showblock('sc_savebutton_<?=$paramdata['id']?>');return false;" id='color<?=$paramdata['id']?>'>
					<br><div id='picker<?=$paramdata['id']?>'></div>
					<script type="text/javascript" charset="utf-8">$(document).ready(function() {$('#picker<?=$paramdata['id'];?>').farbtastic('#color<?=$paramdata['id'];?>');});</script>					
			<?	}?><br><?
				if ($paramdata['example']){
					?><a onclick="showblock('var_<?=$paramdata['id']?>');return false;" href="" class='menuA'>Пример заполнения</a>
					<div class="heavy-rounded example" id='var_<?=$paramdata['id']?>'>
					<?=$paramdata['example']?></div><?
				}
				# Название переменной
				if($userrole=="root"){
						?><br><input class="form-control1" value="$<?=$paramdata['systemparamname']?>"  readonly="readonly">
						<div class="col-sm-4 jlkdfj1"><p class="help-block">Название переменной</p></div><?
					}
				?></td>
				<td>&nbsp <div id="sc_savebutton_<?=$paramdata['id']?>" style="display:none">
				<a class="large button orange light-rounded" onClick="save_param('<?=$paramdata[id]?>','<?=$paramdata['vartype']?>')">Сохранить</a><br><br></div>
				<? if($userrole=="root"){?><div id="accessbutton_<?=$paramdata['id']?>"><a class="small button blue light-rounded" onClick="ajaxreq('<?=$paramdata[id]?>','<? if($paramdata['showtositeadmin']=="2"){?>admin_access_accept<?} else{?>admin_access_deny<? }?>','change_param','fieldmessage_'+paramid,'adminpanel');save_param('<?=$paramdata[id]?>')"><? if($paramdata['showtositeadmin']=="2"){echo "Разрешить доступ админу";}else{echo "Запретить доступ админу";}?></a></div><?}?>
				</td>
				</tr>
	<?		}
			$prev_param_module_id=$param_module_id;
		}
	} else{?><tr><td></td><td class="heavy-rounded">Настройки не найдены</td><td class="barrel-rounded"></td></tr><?}?>

	
	
	
									</tbody>
								</table>
							</div>



<?
if($userrole=="root"){?>
			<a onClick="showHideSelectionSoft('addnewparam',1000)" id="addnewparamlink">
				<img src="/adminpanel/pics/green-add-circle.png" height="64px" class="imgmiddle">Добавить новый параметр</a><br>
			
			<div style='display: none;' id='addnewparam'>
			<br>
			<? include($_SERVER['DOCUMENT_ROOT']."/adminpanel/adminpanel-siteconfig_creator.php");?><br><br><br>
			<br><br><br></div>
			
			<br><br><br>
			<? }
			
			?>
		</div>
			
	</div>
</div>
</div>

<script type="text/javascript" src="js/ColorPicker2/farbtastic.js"></script>
<link rel="stylesheet" href="js/ColorPicker2/farbtastic.css" type="text/css"/>

<? } else $log->LogError('Adminpanel param is not exist');?>