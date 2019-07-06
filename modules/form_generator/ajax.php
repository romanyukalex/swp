<?php
/****************************************************************
 * Snippet Name : module template (ajax part) 					* 
 * Scripted By  : RomanyukAlex		           					* 
 * Website      : http://popwebstudio.ru	   					* 
 * Email        : admin@popwebstudio.ru     					* 
 * License      : GPL (General Public License)					* 
 * Purpose 	 : some ajax functions							 	*
 * Access		 : via /ajax/								 	*
 ***************************************************************/
$log->LogInfo('Got this file');
if($nitka=='1'){
	if($_REQUEST['action']=="add" or $_REQUEST['action']=="edit"){
		$formname=process_data($_REQUEST['someid'],100);
		# Запрос за данными формы и полями
		$formgeneratorquery= mysql_query ("select * from `$tableprefix-formgenerator-fields` flds,`$tableprefix-formgenerator-forminfo` frmnfo where 
			frmnfo.`form_name`='$formname' and frmnfo.`form_name`=flds.`form_name`;");
		$log->LogDebug('Query was:'."select * from `$tableprefix-formgenerator-fields` flds,`$tableprefix-formgenerator-forminfo` frmnfo where 
			frmnfo.`form_name`='$formname' and frmnfo.`form_name`=flds.`form_name`;");
		
		$fg_fieldscount=mysql_num_rows($formgeneratorquery);
		if($fg_fieldscount!==0 and $fg_fieldscount){
			$log->LogDebug('Found '.$fg_fieldscount.' fields in this form ('.$formname.')');
			while($formdata=mysql_fetch_array($formgeneratorquery)){ #Получаем данные формы
				$script_after_add=$formdata['script_after_add'];
				$script_after_edit=$formdata['script_after_edit'];
				$fieldid[$formdata['field_table']."+".$formdata['field_name']]=$formdata['field_id'];
				$needtable=$formdata['field_table'];
				if($_REQUEST['action']=="edit"){$id_field_name=$formdata['id_field_name'];}
				if(!$struct_queried[$needtable]){ # Получаем структуру нужной таблицы
				
					//echo "Запросили структуру таблицы<br>";
					$structquery= mysql_query("select *	from INFORMATION_SCHEMA.COLUMNS	where TABLE_NAME='$needtable';");
					$struct_queried[$needtable]=1;
					
				} else {mysql_data_seek($structquery,0);}
				
				if(!$_REQUEST[$formdata['field_id']] and $formdata['required']){ # Незаполненные обязательные данные
					$form_gen_add_error=1;
					$message_text.="<span style='color:red'>Поле <b>&laquo;".$formdata['field_label_'.$language]."&raquo;</b> обязательное к заполнению</span><br>";
					$log->LogDebug('There is no '.$formdata['field_label_'.$language].' required field');
				
				} else { # Данные пришли или они не обязательные
				
					$reqvalue=$_REQUEST[$formdata['field_id']];
					if(!$reqvalue){//$message_text.=$formdata['field_id']." = NULL<br>";
						$reqvalue=NULL;
					} 
					
					# Проверка формата данных
					if(!$formdata['script']){ # Нет скрипта обработчика, обработаем стандартно
						if($formdata['field_type']=="tel"){
							# Преобразуем телефоны в цифровой вид перед обрезкой
							$reqvalue=preg_replace("/[^0-9]/i","",(string)$reqvalue);
						}
						
						# Проверяем пришедшие данные на соответствие структуре целевой таблицы
						while($structurefields=mysql_fetch_array($structquery)){
							
							if($structurefields['COLUMN_NAME']==$formdata['field_name']){
								//echo "Найдено поле ".$formdata['field_name']." в структурной таблице<br>";
								if($structurefields['DATA_TYPE']=="varchar") {
									
									$reqvalue=process_data($reqvalue,substr($structurefields['COLUMN_TYPE'],8,-1));
									
								} elseif($structurefields['DATA_TYPE']=="text"){
									$reqvalue=process_data($reqvalue,$structurefields['CHARACTER_OCTET_LENGTH']);
									
								} elseif($structurefields['DATA_TYPE']=="enum"){
									# Получаем варианты enum-а из структуры целевой таблицы
									$enum_variants=explode(",",substr($structurefields['COLUMN_TYPE'],5,-1));
									foreach ($enum_variants as $enum_var){ 
										if ($enum_var=="'".$reqvalue."'") {#Есть вариант равный структурному
										}
									}
									
								} elseif($structurefields['DATA_TYPE']=="int"){
									$reqvalue=process_data($reqvalue,substr($structurefields['COLUMN_TYPE'],4,-1));
									
								} elseif($structurefields['DATA_TYPE']=="date"){ // ДОПИСАТЬ
								} elseif($structurefields['DATA_TYPE']=="email"){ 
								
								/*	
								
									if (filter_var('roman@nazarkin.su', FILTER_VALIDATE_EMAIL))
										echo "E-mail указан верно";
									else 
										echo "E-mail указан НЕ верно!";
										
									if (filter_var('127.0.0.1', FILTER_VALIDATE_IP)) 
										echo "Все верно!";
									else
										echo "IP адрес имеет неверное значение!";
									$options = array(
										'options' => array(	  'min_range' => 3,  'max_range' => 6,
													  )
									);
									if (filter_var(5, FILTER_VALIDATE_INT, $options) !== FALSE) 
										echo "Число является верным (от 3 до 6)";
									else
										echo "Число не верно или находится вне заданного интервала!";
								*/
								}
							}
						}
						if($formdata['field_name']){// Те поля, у кого нет таблицы, обрабатывать и формировать массив не будем
							$insertdata[$formdata['field_table']][]= array ( $formdata['field_name'] => $reqvalue);
						}
					} else { # Есть свой обработчик поля. На выходе: $insertdata[$formdata['field_table']][]
						include($_SERVER["DOCUMENT_ROOT"].$formdata['script']);
					}
					
					/*echo "Итерация:Элемент таблицы ".$formdata['field_table']." = ".$reqvalue."<br>"";
					var_export($insertdata);
					echo "<br><br>";
					*/
				}
			} //Перебрали все поля из формы
			if(!$form_gen_add_error==1 and $_REQUEST['action']=="add"){ # Пишем данные в табличку
				foreach($insertdata as $inserttable => $insertdata1){
					
					foreach($insertdata1 as $insert_num => $insert_val){
						foreach($insert_val as $insert_field => $insert_value){ 
								$header_text.="`$insert_field`,";
								if ($insert_value) $values_text.="'$insert_value',";
								else $values_text.="NULL,";
						}
					}
					$add_newdata_query_text="INSERT INTO `$inserttable`(".substr($header_text,0,-1).")VALUES(".substr($values_text,0,-1).");";
					$add_newdata_query=mysql_query($add_newdata_query_text);
					if($add_newdata_query) $message_text.="<span style='color:green;font-size:bold'>".sitemessage('form_generator','add_is_complete')."</span>";
					else $message_text.="<span style='color:red;'>".sitemessage('form_generator','add_is_not_complete')."</span>";
				}
			} elseif(!$form_gen_add_error==1 and $_REQUEST['action']=="edit"){

				$edit_id=process_data($_REQUEST['edit_id'],11);
				$edit_data_query_text="UPDATE `$needtable` SET ";			
				foreach($insertdata as $inserttable => $insertdata1){
					foreach($insertdata1 as $insert_num => $insert_val){
						foreach($insert_val as $insert_field => $insert_value){
							if($insert_value)$edit_data_query_text.="`$insert_field`='$insert_value',";
							else $edit_data_query_text.="`$insert_field`=NULL,";
						}
					}
				}
				$edit_data_query_text=substr($edit_data_query_text,0,-1);
				$edit_data_query_text.=" WHERE `$id_field_name` = '$edit_id';";
				$edit_data_query=mysql_query($edit_data_query_text);
				if($edit_data_query) $message_text.="<span style='color:green;font-size:bold'>".sitemessage('form_generator','edit_is_complete')."</span>";
				else $message_text.="<span style='color:red;'>".sitemessage('form_generator','edit_is_not_complete')."</span>";
			}
			if ($script_after_add and $_REQUEST['action']=="add" and $add_newdata_query){ # Вставляем скрипт после добавления
				//echo "Вставляем скипт";
				include($_SERVER["DOCUMENT_ROOT"].$script_after_add);
			} elseif ($script_after_edit and $_REQUEST['action']=="edit" and $edit_data_query){# Вставляем скрипт после исправления
				include($_SERVER["DOCUMENT_ROOT"].$script_after_edit);
			}
		} else {# Не найдены поля формы или сама форма
			$log->LogDebug('The form ('.$formname.') is not found or the form has 0 fields');
			$message_text.="<span style='color:red;'>".sitemessage('form_generator','form_is_not_found')."</span>";
		}

		
		# Результат:
		echo $message_text;
		
		//echo "FIELDID: ";var_dump($fieldid);echo "<br><br>";
		//echo "LENGTH ";var_dump($length_arr);echo "<br><br>";
		//echo "STRUCTURE ";var_dump($structure_arr);echo "<br><br>";
		//echo "<br>FORMTABLEDATA";var_dump ($formtabledata);echo "<br><br>";
		//echo "<br>INSERTDATA";var_dump($insertdata);echo "<br><br>";
	
	} else {echo sitemessage('$modulename',"action_is_not_found");}
}?>