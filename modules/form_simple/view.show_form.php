<?php
 /**************************************************************************\
  * Snippet Name : modulename		           					 			*
  * Part		 : view (view)												*
  * Scripted By  : RomanyukAlex		           					 			*
  * Website      : http://popwebstudio.ru	   					 			*
  * Email        : admin@popwebstudio.ru     					 			*
  * License      : GPL (General Public License)					 			*
  * Purpose 	 : do something								 				*
  * Access		 : 															*
  * insert_module('modulename','get_some',$get_detail_arr)					*
  \*************************************************************************/
$log->LogDebug('Got this file');
if ($nitka=='1'){?>
<form id="<?=$formname?>" class="formGenerator_form">
<table id="table_<?=$formname?>" class="formGenerator_table"><?
	$fg_numnow=0;
	while($formdata=mysql_fetch_array($formgeneratorquery)){
		
		if($fg_numnow==0){?>
			<tr>
				<td colspan="2"><h3><?=$formdata['form_title']?></h3></td>
			</tr>
			<tr>
				<td colspan="2">
					<span style="color:green" id="form_<?=$formname?>_apOK"></span>
					<span style="color:red" id="form_<?=$formname?>_apNOK"></span>
				</td>
			</tr>
			
		<?
		}		
		?> <tr <? if($formdata['field_type']=="hidden"){?> style="visibility:hidden"<?}?> class="formSimple_tr"><td <?if($formdata['required']=="required"){?> title="Поле обязательно к заполнению"<?}?>
		><?=$formdata['field_label_'.$language]; // Пишем лейбл строки
		if($formdata['required']=="required"){echo " <b>*</b>";} // Пишем звездочку, если required
		?></td>
		<td id="<?=$formname."_".$formdata['field_id']."_td2"?>">
	<? 	if($formdata['static_value']){ # Статическое поле
			?><input type="text" id="<?=$formname."_".$formdata['field_id']?>" name="<?=$formdata['field_id']?>"<?if($formdata['required']=="1"){echo " required";}?> value="<?=$formdata['static_value']?>" readonly><?

		} elseif($formdata['field_type']=="text"){ //Простое текстовое поле
			?>
			<input type="text" id="<?=$formname."_".$formdata['field_id']?>" name="<?=$formdata['field_id']?>" <? 
			if($formdata['field_type']=="tel" and $formdata['input_pattern']){?>pattern="<?=$formdata['input_pattern']?>"<?}?>/>
			<?		
		} elseif($formdata['field_type']=="SELECT"){?><select id="<?=$formname."_".$formdata['field_id']?>" name="<?=$formdata['field_id']?>"></select><?
		} else {?><input type="<?=$formdata['field_type']?>" id="<?=$formname."_".$formdata['field_id']?>" name="<?=$formdata['field_id']?>" <? 
			if($formdata['field_type']=="tel" and $formdata['input_pattern']){?>pattern="<?=$formdata['input_pattern']?>"<?}?>/>
	<?	}
		
		
	?></td></tr>
	<?	if($fg_numnow==$fg_fieldscount-1){ //Выведем Кнопку?>
	
			<tr class="formSimple_tr"><td colspan="2"><a id="sendFormButton" href="" style="cursor:pointer;" 
			<? 	if($formdata['button_class']){?>class="<?=$formdata['button_class']?>"<?}
			?>onclick="saveform3('','<?=$formname?>','form_<?=$formname?>_apOK','form_<?=$formname?>_apNOK','<?=$modulename?>','form_post','resetform','');return false;"<??>><?=$formdata['buttontext']?></a></td></tr><?
		}
		
		$fg_numnow++;
	}
	?>
			<tr style="display:none" class="formSimple_tr">
			<td colspan="2">
				<a class="justlink" href="#"onclick="showHideTr_byClass('formSimple_tr',1000);return false;">Ввести ещё одного участника</a>
			</td>
			
			</tr>
	
		</table>
	</form>
	
<?}?>
<script>
function good_post(){
	//hidetr('<?=$formname?>','амили',1000);
	showHideTr_byClass('formSimple_tr',1000);
	
}
</script>