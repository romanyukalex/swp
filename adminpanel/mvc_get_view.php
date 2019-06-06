<? # Скрипт, выдающий view модуля
if(isset($show_view)){ # Надо выдать view
	
	if(is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/ap.view.'.$show_view.'.php')){
		$log->LogDebug('AP view ('.$show_view.') was found in /project/'.$projectname.'/modules_data/ap.view.'.$show_view.'.php');
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/ap.view.'.$show_view.'.php');
	}
	elseif (is_readable($_SERVER['DOCUMENT_ROOT'].'/adminpanel/templates/'.$adminsitetemplate.'/view.'.$show_view.'.php')) {#Вызванный view с дизайном темплейта
		$log->LogDebug('AP view ('.$show_view.') was found in /adminpanel/templates/'.$adminsitetemplate);
		include($_SERVER['DOCUMENT_ROOT'].'/adminpanel/templates/'.$adminsitetemplate.'/view.'.$show_view.'.php');
	} elseif (is_readable($_SERVER['DOCUMENT_ROOT'].'/adminpanel/standart_views/view.'.$show_view.'.php')) {# View ap общий
		$log->LogDebug('Standart module view ('.$show_view.') will be used');
		include($_SERVER['DOCUMENT_ROOT'].'/adminpanel/standart_views/view.'.$show_view.'.php');
	} else {
		$log->LogError($modulename.' module view ('.$show_view.') is not found at all');
	}
} else { // Нет указателя view
	$log->LogError('show_view parameter is not found at the start of script ('.$show_view.')');
}?>