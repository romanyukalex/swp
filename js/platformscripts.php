<?php header('Content-type: application/javascript');

$nitka=1;
$platscriptflag=1;
if(isset($_REQUEST['adminpanel'])){$adminpanel=1;}
@require($_SERVER["DOCUMENT_ROOT"]."/core/projectname.php");
require($_SERVER["DOCUMENT_ROOT"]."/core/system-param.php");
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); //Уровень логов в apache
header("Expires: ".strftime("%a, %d %b %Y %H:%M:%S",time()+$platfscrpts_cachetime-3600*3)." GMT");
@require_once($_SERVER["DOCUMENT_ROOT"]."/core/functions/KLogger.php");
if ($adminpanel==1) $log=new KLogger( $ap_loglevel);
elseif($nitka==1) $log=new KLogger($loglevel);

$log->LogInfo('------ The new PlatformScripts request on '.$_SERVER['HTTP_HOST'].' ------');

function put_handle($handle){
	while (!feof($handle)) {$buffer = fgets($handle, 4096);echo $buffer;}fclose($handle);
}



$handle = fopen($fullpath."/js/md5.js", "r");
put_handle($handle);


$handle = fopen($fullpath."/js/platformscripts.js", "r");
put_handle($handle);

if($showtexturlclickable=="Сделать"){
$handle = fopen($fullpath."/js/text-url-are-clickable.js", "r");
put_handle($handle);
}
if($click_eq_msdown=="Включить" and $adminpanel!==1){
	?>document.onmousedown = function(e){e.target.click();}<? //Проверить
}

if($adminpanel==1){
	$handle = fopen($fullpath."/adminpanel/js/adminscripts.js", "r");
	put_handle($handle);
}

# Считываем JS из подключенных модулей (не работают скрипты почему то)
$log->LogDebug("Trying to check available modules");
@require($_SERVER["DOCUMENT_ROOT"]."/core/check_avail_modules.php");
echo "\r\n";
foreach($moduleenabled as $modulename=>$enabled){
	$javascripts=null;
	# Читаем конфиг модуля
	if (is_readable($_SERVER["DOCUMENT_ROOT"]."/project/".$projectname."/modules_data/".$modulename.".config.php")) {#Конфиг модуля в папке проекта
		include($_SERVER["DOCUMENT_ROOT"]."/project/".$projectname."/modules_data/".$modulename.".config.php");
		$log->LogDebug("Module config is in /project/".$projectname."/modules_data/");
	} elseif (is_readable($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/config.php")) {#Конфиг модуля общий
		include($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/config.php");
		$log->LogDebug("Module config is in /modules/".$modulename."/");
	}
	if($javascripts){
		foreach($javascripts as $module_script){
			$handle = fopen($fullpath."/modules/".$modulename."/".$module_script, "r");
			put_handle($handle);
		}
		unset($javascripts);
	}
}


?>