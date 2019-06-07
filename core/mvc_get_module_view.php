<? # Скрипт, выдающий view модуля
//if(isset($show_view)){ # Надо выдать view
	if (is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$modulename.'.view.'.$show_view.'.php')) {#Вызванный view модуля в папке проекта
		$log->LogDebug('Module view ('.$show_view.') was found in /project/'.$projectname.'/modules_data/');
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$modulename.'.view.'.$show_view.'.php');
	} elseif (is_readable($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/view.'.$show_view.'.php')) {# View модуля общий
		$log->LogDebug('Standart module view ('.$show_view.') will be used');
		include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/view.'.$show_view.'.php');
	} else {
		$log->LogError($modulename.' module view ('.$show_view.') is not found at all');
	}
/*
} else { // Нет указателя view
	$log->LogError('Show_view parameter is not found at the start of script ('.$show_view.')');
}?>