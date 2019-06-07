<? /*********************************************************************************************************
  * Snippet Name : start_platform_scripts           														*
  * Scripted By  : RomanyukAlex		           																*
  * Website      : http://popwebstudio.ru	   																*
  * Email        : admin@popwebstudio.ru  					 												*
  * License      : License on popwebstudio.ru from autor		 											*
  * Purpose 	 : Стартует сессию, инклюдит все необходимые проекту скрипты, делаются проверки на $block	*
  * Insert		 : include_once('start_platform_scripts.php');												*
  **********************************************************************************************************/
session_start();
gc_enable();
@include($_SERVER['DOCUMENT_ROOT'].'/core/projectname.php');
@include_once($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/config.php');#Cистемные параметры, конфиги БД, папки и т.п.
if($install_swp==1){# Из системных параметров пришёл флаг на установку SWP, первый запуск нового проекта
	$nitka=1;
	include($_SERVER['DOCUMENT_ROOT'].'/pages/install.php');die();
}
#Определяем, бот ли. В начале, так как надо снизить нагрузку на БД при обработке трафика от ботов
include_once($_SERVER['DOCUMENT_ROOT'].'/core/functions/isBot.php');
isBot($bot_name);
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/system-param.php');#Параметры портала, юзер сеттинги
settype($sessionlifetime,integer);
ini_set('session.gc_maxlifetime', $sessionlifetime*60);

if($php_log_enabled=='Включить логирование'){
	ini_set('log_errors', 'On');
	if(isset($PHP_errors_log))ini_set('error_log', $PHP_errors_log);// PHP ошибки
	if (!isset($_SESSION['mode']) or (isset($_SESSION['mode']) and $_SESSION['mode']!=='debug')) error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);# Уровень логов в apache в обычном режиме
}
@include($_SERVER['DOCUMENT_ROOT'].'/core/functions/KLogger.php');
if ($adminpanel==1) {
	$log=new KLogger( $ap_logfile , $ap_loglevel );
} elseif($nitka==1 and !$bot_name) {
	$log=new KLogger( $logfile , $loglevel);
} elseif($nitka==1 and $bot_name) {
	$log=new KLogger( $logfile , "INFO");
}

//Перенести сюда темплейт менеджер и создавать новый log если там другие параметры
$log->LogInfo('----- The new request to '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']. ' [loglevel is '. $loglevel.']----------------');
$log->LogInfo('Session id is '.session_id());
if($_SERVER['HTTP_REFERER']){$log->LogInfo('Referer is '.$_SERVER['HTTP_REFERER']);}
if($redirect_www=='Убирать WWW' and substr($_SERVER['HTTP_HOST'],0,4)=='www.'){
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: http://'.substr($_SERVER['HTTP_HOST'],4).$_SERVER['REQUEST_URI']);
	header('Expires: '.strftime("%a, %d %b %Y %H:%M:%S",time()+$redirect_cachetime-3600*3).' GMT');
	$log->LogInfo('Query redirected (301) to '.substr($_SERVER['HTTP_HOST'],4).$_SERVER['REQUEST_URI']);
	exit();
} elseif($redirect_www=='Добавлять WWW,если нет' and substr($_SERVER['HTTP_HOST'],0,4)!=='www.'){
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: http://www.'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	header('Expires: '.strftime("%a, %d %b %Y %H:%M:%S",time()+$redirect_cachetime-3600*3).' GMT');
	$log->LogInfo('Query redirected (301) to www.'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	exit();
}

// Простые php функции из папки /core/functions/ вставляем вручную
$log->LogDebug('Trying to call insert_function_function.php');
include $_SERVER['DOCUMENT_ROOT'].'/core/insert_function_function.php';// Вызов: insert_function("functionname")

$log->LogDebug('Trying to insert insert_module function');
include $_SERVER['DOCUMENT_ROOT'].'/core/insert_module_function.php';

include  $_SERVER['DOCUMENT_ROOT'].'/core/autoload_scripts_from_functions.php';

$log->LogDebug('Trying to check available modules');
@include($_SERVER['DOCUMENT_ROOT'].'/core/check_avail_modules.php');

$log->LogDebug('Trying to get browser');
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/browser.php');

//$log->LogDebug('Trying to check if it is bot');
//@include($_SERVER['DOCUMENT_ROOT'].'/core/check_bots.php');
#Проверяем, не бот ли
//insert_function("isBot");
if( isBot($bot_name) )$log->LogInfo('This is BOT:'.$bot_name.' UserAgent is '.$_SERVER['HTTP_USER_AGENT']);
else $log->LogDebug('This is not bot, but simple user.'.$bot_name);

$log->LogDebug('Trying to found injection');
@include($_SERVER['DOCUMENT_ROOT'].'/core/check_injection.php');
if(!$adminpanel){
	$log->LogDebug('Trying to get template from get');
	@include_once($_SERVER['DOCUMENT_ROOT'].'/core/templatefromget.php');#Определение $sitetemplate
}
$log->LogDebug('Trying to get page from get');
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/pagefromget.php');#Определение $page

if(!$bot_name){
	$log->LogDebug('Trying to get mode from get');
	@include_once($_SERVER['DOCUMENT_ROOT'].'/core/modefromget.php');#Определение $mode (я это бросил использовать? )
}
$log->LogDebug('Trying to get menu from get');
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/menufromget.php');#Определение $menureq

$log->LogDebug('Trying to get language from get');
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/langfromget.php');#Определение $language

if(!$bot_name){
	$log->LogDebug('Trying to get all site messages from DB');
	@include_once($_SERVER['DOCUMENT_ROOT'].'/core/messages.php');#Все сообщения портала на языке портала
}

if ($shutdownsite=='НЕ ПОКАЗЫВАТЬ'){
	$log->LogDebug('Site shutdowned by admin');
	$block=1;
}
if ($autoincludeclasses=='Включено'){//автозагрузка классов из папки /core/functions/
	$log->LogDebug('Trying to call autoload_scripts_from_functions.php');
	@include_once($_SERVER['DOCUMENT_ROOT'].'/core/autoload_scripts_from_functions.php');
}
if ($includeemail=='Включено'){
	$log->LogDebug('Trying to insert SEND_LETTER function');
	insert_function('send_letter');
}
$log->LogDebug('Trying to get amp type');
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/fromget_amp.php');
?>