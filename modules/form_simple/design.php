<?php
 /***********************************************************************************************
  * Snippet Name : Form Generator           					 								* 
  * Scripted By  : RomanyukAlex		           					 								* 
  * Website      : http://popwebstudio.ru	   					 								* 
  * Email        : admin@popwebstudio.ru     					 								* 
  * License      : GPL (General Public License)													* 
  * Purpose 	 : Generate any forms							 								*
  * Access		 : insert_module("form_generator","show_form","form_name");						*
insert_module("form_generator","edit_form","from-organization_form","$company_id");			    *
  ***********************************************************************************************/
$log->LogInfo('Got this file');
if ($nitka=='1'){
	if($param[1]=="show_form" or $param[1]=="edit_form"){
		$formname=$param[2];
		if ($param[1]=="edit_form") {$fm="edit_form";$object_id=$param[3];}
		else $fm="show_form";
		# Запрос за данными формы и полями
		$formgeneratorquery=mysql_query("select * from `$tableprefix-formgenerator-fields` flds,`$tableprefix-formgenerator-forminfo` frmnfo where 
		frmnfo.`form_name`='$formname' and 
		frmnfo.`form_name`=flds.`form_name` ORDER BY flds.`ordernum`;");
		$fg_fieldscount=mysql_num_rows($formgeneratorquery);
		if($fg_fieldscount!==0){ //Есть поля в такой форме, формируем табличку с формой
			?><table id="table_<?=$formname?>" class="formGenerator_table"><?
			$fg_numnow=0;
			while($newformdata=mysql_fetch_array($formgeneratorquery)){
				$needtable=$newformdata['field_table'];
				if(!$structurequeried[$needtable]){ # Получаем структуру нужной таблицы
					$structquery= mysql_query("select *
						from INFORMATION_SCHEMA.COLUMNS
						where TABLE_NAME='$needtable';");
					while($structurefileds=mysql_fetch_array($structquery)){
						if($structurefileds['DATA_TYPE']=="varchar" or $structurefileds['DATA_TYPE']=="text" or $structurefileds['DATA_TYPE']=="int") {
							$structure_arr[$needtable.'_'.$structurefileds['COLUMN_NAME']]="textfield";
						} elseif($structurefileds['DATA_TYPE']=="enum"){
							# Получаем варианты enum-а
							$enum_variant[$needtable.'_'.$structurefileds['COLUMN_NAME']]=explode(",",substr($structurefileds['COLUMN_TYPE'],5,-1));
							
							if(count($enum_variant[$needtable.'_'.$structurefileds['COLUMN_NAME']])>3){$structure_arr[$needtable.'_'.$structurefileds['COLUMN_NAME']]="select";}
							else {$structure_arr[$needtable.'_'.$structurefileds['COLUMN_NAME']]="radio";}
						}
					}
					?><input type="hidden" name="fieldtable" value="<?=$needtable?>" /><?
					$structurequeried[$needtable]=1;
					if($fm=="edit_form"){# Получаем данные для внесения value
						//echo $newformdata['id_field_name'].$object_id;
						$id_field_name=$newformdata['id_field_name'];
						
						$formdata_val=mysql_fetch_array(mysql_query("select * from `$needtable`	where `$id_field_name`='$object_id';"));
						?><input type="hidden" name="edit_id" value="<?=$object_id?>" /><?
					}
				
				
				}
				?> <tr<? if($newformdata['field_type']=="hidden"){?> style="visibility:hidden"<?}?>><td<?if($newformdata['required']=="1"){?> title="Поле обязательно к заполнению"<?}?>
				><?=$newformdata['field_label_'.$language]; // Пишем лейбл строки
				if($newformdata['required']=="1"){echo " <b>*</b>";} // Пишем звездочку, если required
				?></td>
				<td id="<?=$formname."_".$newformdata['field_id']."_td2"?>">
			<? 	if($newformdata['script']){ # Есть скрипт, который выдаст поле
					include($_SERVER["DOCUMENT_ROOT"].$newformdata['script']);
				
				} elseif($newformdata['static_value']){ # Статическое поле
					$findme   = '$';
					$pos = strpos($newformdata['static_value'], $findme);
					if ($pos === false) {//Строка '$findme' не найдена в строке $newformdata['static_value']
						$static_value=$newformdata['static_value'];
					} else { //Строка '$findme' найдена в строке $newformdata['static_value']
						$static_value=$newformdata['static_value'];
						global $company_id;
						eval ("\$static_value = \"$static_value\";");
					}
					?><input type="text" id="<?=$formname."_".$newformdata['field_id']?>" name="<?=$newformdata['field_id']?>"<?if($newformdata['required']=="1"){echo " required";}?> value="<?=$static_value?>" readonly><?
 
				} else{ # Данные по полю берем из БД
					if($newformdata['field_type']=="-"){
						if ($structure_arr[$needtable.'_'.$newformdata['field_name']]=="textfield"){ # Текстовое поле ?>
						<input type="text" id="<?=$formname."_".$newformdata['field_id']?>" name="<?=$newformdata['field_id']?>"<?if($newformdata['required']=="1"){echo " required";}
						if($fm=="edit_form"){echo " value='".$formdata_val[$newformdata['field_name']]."'";}
						?>/>
					<?	} elseif($structure_arr[$needtable.'_'.$newformdata['field_name']]=="radio"){ # Радиобуттон
							$varnum=0; // Номер варианта enum
							$enum_var_text=explode(",",$newformdata['enum_vars_texts_'.$language]);
							foreach($enum_variant[$needtable.'_'.$newformdata['field_name']] as $enum_var){
								 // ДОПИСАТЬ Если есть лейбл в formgenerator?>
									<input type="radio" id="<?=$formname."_".$newformdata['field_id']?>" name="<?=$newformdata['field_id']?>" value="<?=substr($enum_var,1,-1)?>"<? 
									if($fm=="show_form" and $varnum==0){echo " checked='checked'";}
									elseif($fm=="edit_form"){ // ДОПИСАТЬ
									}
									?>><?=substr($enum_var_text[$varnum],1,-1);
								
								$varnum++;
							}
						} elseif($structure_arr[$needtable.'_'.$newformdata['field_name']]=="select"){echo "select";// ДОПИСАТЬ
						} elseif($structure_arr[$needtable.'_'.$newformdata['field_name']]==""){echo "select";// ДОПИСАТЬ
						}																																						
					} elseif($newformdata['field_type']=="text"){ //Простое текстовое поле
					?>
					<input type="text" id="<?=$formname."_".$newformdata['field_id']?>" name="<?=$newformdata['field_id']?>" <? if($newformdata['field_type']=="tel" and $newformdata['input_pattern']){?>pattern="<?=$newformdata['input_pattern']?>"<?}?>/>
					<?
						
					} elseif($newformdata['field_type']=="SELECT"){?><select id="<?=$formname."_".$newformdata['field_id']?>" name="<?=$newformdata['field_id']?>"></select><?
					} else {?><input type="<?=$newformdata['field_type']?>" id="<?=$formname."_".$newformdata['field_id']?>" name="<?=$newformdata['field_id']?>" <? if($newformdata['field_type']=="tel" and $newformdata['input_pattern']){?>pattern="<?=$newformdata['input_pattern']?>"<?}?>/>
				<?	}
				}
				
			?></td></tr>
			<?	if($fg_numnow==$fg_fieldscount-1){ //Кнопка?>
			
				<tr><td colspan="2"><a href="" style="cursor:pointer" 
				<? 	if($newformdata['button_class']){?>class="<?=$newformdata['button_class']?>"<?}
				if($newformdata['JSonSubmit']){?>onclick="<?=$newformdata['JSonSubmit']?>;return false;"<?}?>><?=$newformdata['buttontext']?></a></td></tr><?}
				$fg_numnow++;
			}
			?></table><?
		} else {echo "Форма с таким имнем не найдена";}
	}
}?>