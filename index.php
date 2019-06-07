<? $base_memory_usage = memory_get_usage(); # Определяем, сколько было скушано памяти в начале
@include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts.php');
# Блокировка IE6
if($showsiteforie6=='Предлагать другие браузеры' and $browser=='ie' and $browserversion=='6'){ # Предлагаем сменить браузер
	$log->LogDebug('Trying to show /pages/ie6decline/index_'.$language.'.html');
	@include($_SERVER['DOCUMENT_ROOT'].'/pages/ie6decline/index_'.$language.'.html');exit();
}
if(is_file($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/before_http.php')) { //Хедеры проекта (Coocies,например)
	include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/before_http.php');
}
if ($reconstruction_page!=='Включить' or ($reconstruction_page=='Включить' and $mode=='debug')) {# Доктайп этого проекта
	$log->LogDebug('Trying to get /project/'.$projectname.'/templates/'.$sitetemplate.'/doctype.php');
	@include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/doctype.php');
}
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

if($_REQUEST['action']!=='index_this') {
	$log->LogDebug('Trying to get platform_header');
	# meta теги платформы, заголовки от модулей и тп
	include($_SERVER['DOCUMENT_ROOT'].'/core/platform_header.php');
	$log->LogDebug('Trying to call /project/'.$projectname.'/templates/'.$sitetemplate.'/scripts_and_styles.php');
	include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/scripts_and_styles.php');// Скрипты и стили проекта
}
# Перенаправление на мобильную версию, если необходимо
/*
# Разрешено ли этому IP смотреть сайт? (перенеcено в модули)
if($sitecorrectipaddress!=='NO'){
	$valid_ip_address=$sitecorrectipaddress;
	$log->LogDebug('Trying to call /modules/IPfilter/design.php');
	include($_SERVER['DOCUMENT_ROOT'].'/modules/IPfilter/design.php');
}*/
# Определяем userrole
$log->LogDebug('Trying to check userrole');
require($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); //(перенести вызов "/core/start_platform_scripts.php" и в usermanagement )
?></head><body <? if($bodyclass and !$ampreq)?>class='<?=$bodyclass?>'><?
#### Тело страницы ####

if ($reconstruction_page=='Включить' and $mode!=='debug'){ # Перенаправление на страницу 'сайт на реконструкции', если необходимо

	$log->LogDebug('Trying to call /pages/reconstruction_page/body.php');
	include($_SERVER['DOCUMENT_ROOT'].'/pages/reconstruction_page/body.php');

} elseif($ampreq){ #Запрос на AMP страницу, подсасываем шаблоны AMP
	
	include($_SERVER['DOCUMENT_ROOT'].'/core/pagemanage_amp.php');
	
}
else { # Вызов основной формы страницы
	if($_REQUEST['action']!=='index_this') {
	$log->LogDebug('Trying to call /project/'.$projectname.'/templates/'.$sitetemplate.'/body.php');
	?><div itemscope itemtype="http://schema.org/Article"><?
	include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/body.php');
	?></div><?
	} else {#Выдаем контент страницы, без шаблона (для индексирования)
		include($_SERVER['DOCUMENT_ROOT'].'/core/pagemanage.php');
	}
require($_SERVER['DOCUMENT_ROOT'].'/core/platform_jscss.php');// Стандартные js и css платформы
}
?>
</body>
</html>
<? 
$log->LogDebug('MemUsage (after all) '.(memory_get_usage()-$base_memory_usage).'. Memory peak was '.memory_get_peak_usage().'.');

$data = getrusage();
$log->LogDebug("CPU usage.User time: ".($data['ru_utime.tv_sec'] +$data['ru_utime.tv_usec'] / 1000000));
$log->LogDebug("CPU usage.System time: ".	($data['ru_stime.tv_sec'] +	$data['ru_stime.tv_usec'] / 1000000));
$log->LogInfo('EndOfPage -------------------');