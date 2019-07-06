<?php header('Content-type: text/css'); 
$nitka=1;
$styleflag=1;
if(isset($_REQUEST['adminpanel'])){$adminpanel=1;}
@require($_SERVER['DOCUMENT_ROOT'].'/core/projectname.php');
require($_SERVER['DOCUMENT_ROOT'].'/core/system-param.php');
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);//Уровень логов в apache
header('Expires: '.strftime("%a, %d %b %Y %H:%M:%S",time()+$stylecss_cachetime-3600*3).' GMT');
@require_once($_SERVER['DOCUMENT_ROOT'].'/core/functions/KLogger.php');
if ($adminpanel==1) $log=new KLogger( $ap_loglevel);
elseif($nitka==1) $log=new KLogger( $loglevel);
$log->LogInfo('------ The new STYLE request from '.$_SERVER['HTTP_HOST'].' ------');
$log->LogDebug('Trying to call insert_function_function.php');
include_once $_SERVER['DOCUMENT_ROOT'].'/core/insert_function_function.php';
$log->LogDebug('Trying to get browser.php');
require($_SERVER['DOCUMENT_ROOT'].'/core/browser.php');
?>
body {
background:<?=$bodybackgrcolor;?>;
<? if ($hidehorizontalscroll=='Не разрешать горизонтальную прокрутку'){echo 'overflow-x:hidden;';} ?>
scroll-behavior: smooth; // Работает только в FF - плавная прокрутка на CSS
}

a{text-decoration:<? if ($linkdecoration=='Подчеркнуть'){echo 'underline';}elseif($linkdecoration=='Не подчеркивать'){?>none<? }?>
}

<? 

$handle = fopen($fullpath.'/style/platform_style.css', 'r');
while (!feof($handle)) {$buffer = fgets($handle, 4096);echo $buffer;}fclose($handle);

if ($reconstruction_page=='Включить'){?>
#bannernothing { background: #000; height: 100px; position: absolute; top: 0px; left: 0px; width: 100%; border-bottom: 15px solid #666; } 
#contentnothing { background: transparent url(pics/logo.jpg) no-repeat center center; width: 100%; height: 147px; position: absolute; top: 50%; left: 0px; margin-top: -73px; }
#footernothing {background: #000; height: 100px; position: absolute; width: 100%; top: 100%; left: 0px; margin-top: -115px; border-top: 15px solid #666;}
#messagenothing {width: 500px; position: absolute; top: 100%; left: 50%; height: 25px; margin-top: -25px; margin-left: -250px; z-index: 3; text-align: center; color: #666; color: #fff;}
<? } // стили для страницы реконструкции
?>

<? if($appendbuttonsstyle=='Присоединить' or $adminpanel==1){include('buttons.php');}
   if($appendcheckboxradiocss3style=='Присоединить'){ include('checkbox-radio-css3/checkbox-radio-css3-style.php'); }
   if($append_hover_style=='Присоединить'){ 
		$handle = fopen($fullpath.'/style/hover.css', 'r'); while (!feof($handle)) {$buffer = fgets($handle, 4096);echo $buffer;}fclose($handle);
   }
if($adminpanel){
	include('adminpanel-style.php');
}
# Считываем CSS из подключенных модулей
$log->LogDebug('Trying to check available modules');
@require($_SERVER['DOCUMENT_ROOT'].'/core/check_avail_modules.php');
echo '\n';
foreach($moduleenabled as $modulename=>$enabled){
	$css=null;
	# Читаем конфиг модуля
	if (is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$modulename.'.config.php')) {#Конфиг модуля в папке проекта
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$modulename.'.config.php');
		if($mode=='debug') $log->LogDebug('Module config is in /project/'.$projectname.'/modules_data/');
	} elseif (is_readable($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/config.php')) {#Конфиг модуля общий
		include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/config.php');
		if($mode=='debug') $log->LogDebug('Module config is in /modules/'.$modulename.'/');
	}
	if($css){
		foreach($css as $module_script){
			$handle = fopen($fullpath.'/modules/'.$modulename.'/'.$module_script, 'r');
			while (!feof($handle)) {$buffer = fgets($handle, 4096);echo $buffer;}fclose($handle);	
		}
		unset($css);
	}
}

?>