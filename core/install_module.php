<?


//$param = func_get_args();//Получили все аргументы (должна быть там, где определили функцию)
//global $sitemessage;
//global $nitka,$tableprefix,$language,$log,$moduleinstalled,$userrightsreq,$projectname;
$log->LogInfo('Got this file');
if($nitka==1){
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
		} else $log->LogError('Module config is not found');
		if($modconfigexist){			
			include_once($_SERVER['DOCUMENT_ROOT'].'/core/db/dbconn.php');
			# Ставим метку об инсталляции в реестр модулей
			$modregisterqry=mysql_query("INSERT into `$tableprefix-modulesregister` 
			(`module_id` ,`modulename` ,`moduletype`,`module_description` ,`installed` ,`install_ts` ,`enabled` )VALUES 
			(NULL , '$modulename', '$moduletype', '$module_description', 'y', CURRENT_TIMESTAMP , 'enabled');");
			$module_id=mysql_insert_id();
			# Если есть файл-инсталлятор
			if (is_readable($_SERVER['DOCUMENT_ROOT'].'/modules/'.$param[0]."/install_module.php")) {
				include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$param[0]."/install_module.php"); // Подсосали структуры
				# Для новых инсталляторов
				if(isset($structures) or isset($DBdata)) include($_SERVER['DOCUMENT_ROOT'].'/core/install_structures_into_db.php');
			}
			if(($module_id and $modregisterqry)or $install_errcount==0) {# Сообщаем об успехе инсталляции модуля
				echo '<b>'.sitemessage('system','module_installed').': '.$modulename.' ('.$param[0].')</b><br><br>';
				$log->LogInfo('Module is installed successfully');
			} else{
				$log->LogInfo('Module is NOT installed');
				echo "<b style='color=red'>".sitemessage('system','module_not_installed').': '.$modulename.' ('.$param[0].')</b><br><br>';
			}
		} else {$log->LogError('Module is not installed. Module has not config');
			echo "<b style='color=red'>".sitemessage('system','module_hasnot_config').': '.$modulename.' ('.$param[0].')</b><br><br>';
		}		
	} else {$log->LogError('Module is not installed. There is no module name in query');
		echo sitemessage('system','module_name_missed');//"*Пропущено название модуля";
	}
}
?>