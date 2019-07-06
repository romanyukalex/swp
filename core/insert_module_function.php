<?php
$log->LogInfo('Got this file');
function insert_module(){
	$numargs = func_num_args();//Колличество аргументов
	$param = func_get_args();//Получили все аргументы
	//global $sitemessage,
	global $nitka,$tableprefix,$language,$log,$projectname,$bot_name,$module_params_quered;
	if($param[0]) {//Определили модуль для подключения
		
		if(!$module_params_quered[$param[0]]) {//Параметры для этого модуля еще не загружали
			#Подгружаем параметры модуля
			include($_SERVER['DOCUMENT_ROOT'].'/core/system_param_for_module.php');
		}
		# Читаем конфиг модуля
		if (is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$param[0].'.config.php')) {#Конфиг модуля в папке проекта
			$modconfigexist=1;
			include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$param[0].'.config.php');
			$log->LogDebug('Module config is in /project/'.$projectname.'/modules_data/');
		} elseif (is_readable($_SERVER['DOCUMENT_ROOT'].'/modules/'.$param[0].'/config.php')) {#Конфиг модуля общий
			$modconfigexist=1;
			include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$param[0].'/config.php');
			$log->LogDebug('Module config is in /modules/'.$param[0].'/');
		}
		# Требуется ли инсталляция модуля
		global $moduleinstalled,$userrightsreq,$moduleenabled;;
		if($moduleinstalled[$param[0]]!=='y' or !$moduleinstalled[$param[0]]){
			$log->LogDebug('Module should be installed - '.$param[0]);
			if ($modconfigexist==1){
				//install_module("$param[0]");
				require($_SERVER['DOCUMENT_ROOT'].'/core/install_module.php');
			} else $log->LogError('No module config');
		}
		if ($moduleenabled[$param[0]]=='enabled'){ // Сделать moduleenabled функцией, проверяющей включен ли модуль запросом в БД

			if(is_readable($_SERVER['DOCUMENT_ROOT'].'/modules/'.$param[0].'/controller.php')) {// Для MVC-модулей
				
				#Найдем action
				if(isset($param[1])) $contact=$param[1]; // Вызвали как модуль из скрипт
				
				if(!isset($contact)){$contact=$default_action;}
				$log->LogDebug('Action is '.$contact);
				if(is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$param[0].'.action.'.$contact.'.php')) { //Есть альтернативное описание действия для данного проекта
					$log->LogDebug('We got this action processer in project folder');
					include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$param[0].'.action.'.$contact.'.php');
				} else {//Нет специфичного описания action, запускаем обычный контроллер
					include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$param[0].'/controller.php');
					# Расширение контроллера модуля, специфичное для проекта
					if(is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$param[0].'.controller.php')) include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$param[0].'.controller.php');
				}
				if(isset($show_view)){# Показываем view, его вызвали
					include($_SERVER['DOCUMENT_ROOT'].'/core/mvc_get_module_view.php');
				} else { // Нет указателя view
					$log->LogInfo('Show_view parameter is not found ('.$show_view.')');
				}
				# Возвращаем, если что то вернули
				if($return_data) return $return_data;
			} else {// Для простых модулей
				$log->LogDebug('Trying to include module design file for '.$param[0]);
				if (is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$param[0].'.design.php')){
					return include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$param[0].'.design.php');
				} else {
					return include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$param[0].'/design.php');
				}
			}

		} else $log->LogDebug('Module '.$param[0].' is disabled ');
	} else {# Пропущено название модуля
		$log->LogError('Module name has been missed');
		echo sitemessage('system','module_name_missed');
	}
}

//function install_module(){
//	$param = func_get_args();
//	include($_SERVER['DOCUMENT_ROOT'].'/core/install_module.php');
//}?>