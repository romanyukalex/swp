<? $base_memory_usage = memory_get_usage(); # Определяем, сколько было скушано памяти в начале
@include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts.php');

if(is_file($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/before_http.php')) { //Хедеры проекта (Coocies,например)
	include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/before_http.php');
}
if ($reconstruction_page!=='Включить' or ($reconstruction_page=='Включить' and $mode=='debug')) {# Доктайп этого проекта
	$log->LogDebug('Trying to get /project/'.$projectname.'/templates/'.$sitetemplate.'/doctype.php');
	@include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/doctype.php');
}

//Вынести на специальную страницу:
$req_action=null;$req_action=$_REQUEST['action'];
if($req_action=='export_code' or $req_action=='export_db' or $req_action=='delete_exported_code' or $req_action=='delete_exported_dump'){ # Экспортируем код платформы
	include($_SERVER['DOCUMENT_ROOT'].'/core/export_swp.php');
	$log->LogDebug('Procedure '.$req_action.' done. Now die.');
	die();
}
unset($req_action);
?><html <? 
if(!$ampreq) {
if(isset($htmlclass)){?>class='<?=$htmlclass?>'<?}?> lang="<?=$language?>"<? }

else {?>amp<?}
?>><head><?
//Вынести в специальную страницу создания индекса для поиска
//if($_REQUEST['action']!=='index_this') {
	$log->LogDebug('Trying to get platform_header');
	# meta теги платформы, заголовки от модулей и тп
	include($_SERVER['DOCUMENT_ROOT'].'/core/platform_header.php');
	$log->LogDebug('Trying to call /project/'.$projectname.'/templates/'.$sitetemplate.'/scripts_and_styles.php');
	include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/scripts_and_styles.php');// Скрипты и стили проекта
//}
# Определяем userrole
$log->LogDebug('Trying to check userrole');
require($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); //(перенести вызов "/core/start_platform_scripts.php" и в usermanagement )
?></head><body <? if($bodyclass and !$ampreq)?>class='<?=$bodyclass?>'><?
$log->LogDebug('-------START BODY ---------');
#### Тело страницы ####
/*
if ($reconstruction_page=='Включить' and $mode!=='debug'){ # Перенаправление на страницу 'сайт на реконструкции', если необходимо

	$log->LogDebug('Trying to call /pages/reconstruction_page/body.php');
	include($_SERVER['DOCUMENT_ROOT'].'/pages/reconstruction_page/body.php');

} else*/
if($ampreq){ #Запрос на AMP страницу, подсасываем шаблоны AMP
	
	include($_SERVER['DOCUMENT_ROOT'].'/core/pagemanage_amp.php');
	
}
else { # Вызов основной формы страницы
	if($_REQUEST['action']!=='index_this') {

		$log->LogDebug('Trying to call /project/'.$projectname.'/templates/'.$sitetemplate.'/body.php');
	
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/body.php');
		
		session_write_close(); //Закрываем сессии от записей. Чем раньше, тем быстрее отпустит для следующей сессии
		
	} else {#Выдаем контент страницы, без шаблона (для индексирования)
		include($_SERVER['DOCUMENT_ROOT'].'/core/pagemanage.php');
	}
	
	require($_SERVER['DOCUMENT_ROOT'].'/core/platform_jscss.php');// Стандартные js и css платформы

}
$log->LogDebug('-------STOP BODY ---------');
?>
</body>
</html>
<? 
$log->LogDebug('MemUsage (after all) '.(memory_get_usage()-$base_memory_usage).'. Peak was '.(memory_get_peak_usage(TRUE)-$base_memory_usage).'. Absolute memory peak was '.memory_get_peak_usage(TRUE).'. Count of variables in memory is '.count(get_defined_vars ()));

#Подробности о работе и запросах MySQL в лог
if($mysqlDebugToLog=='Писать в лог'){
	#Статус кеширования запросов
	$log->LogDebug('Status of caching in MySQL');
	$rs1 = mysql_query("SHOW GLOBAL STATUS LIKE 'Qcache%';");
	while($rd = mysql_fetch_object($rs1)) $log->LogDebug($rd->Variable_name.' - '.$rd->Value );

	#Выключим отладчик и запишем запросы в лог
	$rs = mysql_query("show profiles");
	while($rd = mysql_fetch_object($rs)) $log->LogDebug('QueryNum -'.$rd->Query_ID.', time - '.round($rd->Duration,4) * 1000 .' ms, qt= '.$rd->Query);

	mysql_query("set profiling=0");
}

$data = getrusage();
$log->LogDebug("CPU usage.User time: ".($data['ru_utime.tv_sec'] +$data['ru_utime.tv_usec'] / 1000000));
$log->LogDebug("CPU usage.System time: ".	($data['ru_stime.tv_sec'] +	$data['ru_stime.tv_usec'] / 1000000));
$log->LogInfo('EndOfPage -------------------');
/*
if((memory_get_usage()-$base_memory_usage)>1000000){#Страница кушала памяти больше чем 1 МБ. Много данных и тп. Оповещаем админа
	insert_function("send_letter");
	$message_megabyte="Здравствуйте.<br>Страница скушала более 1Мб памяти. URL:".$_SERVER['QUERY_STRING'];
	sendletter_to_admin('Страница кушала более 1Мб',$message_megabyte);
}*/