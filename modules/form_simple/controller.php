<?php
 /***********************************************************************************************************\
  * Modulename	: modulename				 																* 
  * Part		: controller																				*
  * Scripted By	: RomanyukAlex		           																* 
  * Website		: http://popwebstudio.ru	   																* 
  * Email		: admin@popwebstudio.ru     																* 
  * License		: GPL (General Public License)																* 
  * Purpose		: control all operations																	*
  * Access		: insert_module("form_simple","show_form","register_to_training");							*
  * for form processing its needed to add /project/pr/modules_data/form_simple.controller.formname.php		*
  * At the end of processing controller use $message_text param as answer to user							*
  \*********************************************************************************************************/
$log->LogInfo('Got this file with params - '.implode(',',$param));
if($nitka=='1'){
	insert_function('process_user_data');
	
	if ($contact=='show_form'){# Показать форму
		
		$formname=$param[2];
		
		# Запрос за данными формы и полями
		$formgeneratorquery=mysql_query("select * from `$tableprefix-$modulename-fields` flds,`$tableprefix-$modulename-forminfo` frmnfo where 
		frmnfo.`form_name`='$formname' and 
		frmnfo.`form_name`=flds.`form_name` ORDER BY flds.`ordernum`;");
		$fg_fieldscount=mysql_num_rows($formgeneratorquery);
		if($fg_fieldscount!==0){ //Есть поля в такой форме, формируем табличку с формой
			$show_view='show_form';
		} else {echo "Форма с таким именем не найдена";}
		
	}
	
	
	
	
	
	elseif($contact=='form_post'){ #Обработка формы
	
		$formname=process_data($_REQUEST['formid'],100);
		# Запрос за данными формы и полями
		$formgeneratorquery= mysql_query ("select * from `$tableprefix-$modulename-fields` flds,`$tableprefix-$modulename-forminfo` frmnfo where 
			frmnfo.`form_name`='$formname' and frmnfo.`form_name`=flds.`form_name`;");
		
		
		$fg_fieldscount=mysql_num_rows($formgeneratorquery);
		if($fg_fieldscount!==0 and $fg_fieldscount){
			$log->LogDebug('Found '.$fg_fieldscount.' fields in this form ('.$formname.')');
			while($formdata=mysql_fetch_array($formgeneratorquery)){ #Получаем данные формы
				$script_after_add=$formdata['script'];
				
				$fieldid[$formdata['field_table']."+".$formdata['field_name']]=$formdata['field_id'];
				$needtable=$formdata['field_table'];
				
				if(!$_REQUEST[$formdata['field_id']] and $formdata['required']=="required"){ # Незаполненные обязательные данные
					$form_gen_add_error=1;
					$message_text.="Поле <b>&laquo;".$formdata['field_label_'.$language]."&raquo;</b> обязательное к заполнению<br>";
					$log->LogDebug('There is no data in '.$formdata['field_label_'.$language].' (required) field');
				
				} else { # Данные по полю пришли или они не обязательные. Обрабатываем их
				
					$reqvalue=$_REQUEST[$formdata['field_id']];
					if(!$reqvalue){
						$reqvalue=NULL;
					} 
					
					# Проверка формата данных
				
					if($formdata['field_type']=="tel"){
						# Преобразуем телефоны в цифровой вид перед обрезкой
						$_REQUEST[$formdata['field_id']]=preg_replace("/[^0-9]/i","",(string)$reqvalue);
					}
					
					
					if($formdata['field_type']=="text" or $formdata['field_type']=="int"){
						$_REQUEST[$formdata['field_id']]=process_data($reqvalue,1000);
							
					} elseif($formdata['field_type']=="SELECT"){
						/* #Дописать
						foreach ($enum_variants as $enum_var){ 
							if ($enum_var=="'".$reqvalue."'") {#Есть вариант равный структурному
							}
						}*/
						
					} elseif($formdata['field_type']=="int"){
						//$reqvalue=process_data($reqvalue,substr($structurefields['COLUMN_TYPE'],4,-1));
						
					} elseif($formdata['field_type']=="date"){ // ДОПИСАТЬ
					} elseif($formdata['field_type']=="email"){ 
					
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
			} //Перебрали все поля из формы
			if(!$form_gen_add_error==1){ # Нет ошибок - запускаем скрипт обработчик
				
					include($_SERVER["DOCUMENT_ROOT"].'/project/'.$projectname.'/modules_data/'.$modulename.'.controller.'.$formname.'.php');
					
					if(!$message_text) $message_text.=sitemessage("$modulename",'add_is_complete');
					$query_status="OK";
					$query_function='good_post()';
			} 
			
		} else {# Не найдены поля формы или сама форма
			$log->LogDebug('The form ('.$formname.') is not found or the form has 0 fields');
			$message_text.=sitemessage("$modulename",'form_is_not_found');
			$query_status="NOK";
			$message_text.=sitemessage("$modulename",'add_is_not_complete');
		}

		
		# Результат:
		echo json_encode(array('status' => $query_status, 'message' => $message_text, 'getfunction'=>$query_function));
		
	}
}
?>