<?php
$log->LogInfo('Got this file');
function insert_module(){
	$numargs = func_num_args();//Колличество аргументов
	$param = func_get_args();//Получили все аргументы
	global $sitemessage,$nitka,$tableprefix,$language,$log,$projectname;
	if($param[0]) {//Определили модуль для подключения

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
			if ($modconfigexist==1){
				install_module("$param[0]");
			}
		}
		if ($moduleenabled[$param[0]]=='enabled'){

			if(is_readable($_SERVER['DOCUMENT_ROOT'].'/modules/'.$param[0].'/controller.php')) {// Для MVC-модулей
				if(isset($param[1])) $contact=$param[1]; // Вызвали как модуль из скрипта
				include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$param[0].'/controller.php');
				# Расширение контроллера модуля, специфичное для проекта
				if(is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$param[0].'.controller.php')) include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$param[0].'.controller.php');
				
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
		echo $sitemessage['system']['module_name_missed'];
	}
}

function install_module(){
	$param = func_get_args();
	include($_SERVER['DOCUMENT_ROOT'].'/core/install_module.php');
}?>