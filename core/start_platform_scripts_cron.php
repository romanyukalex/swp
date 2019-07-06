<?/*********************************************************************************************************\
  * Snippet Name : start_platform_scripts           														* 
  * Scripted By  : RomanyukAlex		           																* 
  * Website      : http://popwebstudio.ru	   																* 
  * Email        : admin@popwebstudio.ru  					 												* 
  * License      : License on popwebstudio.ru from autor		 											*
  * Purpose 	 : Стартует сессию, инклюдит все необходимые проекту скрипты, делаются проверки на $block	*
  * Insert		 : include_once('start_platform_scripts.php');												*
  \*********************************************************************************************************/

$cronflag=1;
if(!$_SERVER['DOCUMENT_ROOT']){
	$breakthisfile = Explode('/', $_SERVER['SCRIPT_NAME']);
	unset ($breakthisfile[count($breakthisfile)-1]); //Удалили название скрипта
	if($breakthisfile[count($breakthisfile)-1]!=='modules')unset ($breakthisfile[count($breakthisfile)-1]); //Мы все еще в глубине файловой системы, удаляем папку с модулем
	unset ($breakthisfile[count($breakthisfile)-1]); //Удаляем /modules
	$_SERVER['DOCUMENT_ROOT']=implode('/', $breakthisfile); // Домашняя директория всего сайта
}

//gc_enable();
echo "OK";
if($argv[1]) $projectname=$argv[1]; // Первый параметр при запуске из командной строки - это название проекта

include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/config.php');#Cистемные параметры

include($_SERVER['DOCUMENT_ROOT'].'/core/system-param_cron.php');#Параметры портала, юзер сеттинги

if($php_log_enabled=='Включить логирование'){
	ini_set('log_errors', 'On');
	if(isset($PHP_errors_log))ini_set('error_log', $PHP_errors_log);// PHP ошибки
	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED  & ~E_WARNING);# Уровень логов в apache в обычном режиме
}

if(!class_exists('KLogger')){
	include($_SERVER['DOCUMENT_ROOT'].'/core/functions/KLogger.php');
}

$log=new KLogger( $loglevel_cron);
$log->LogInfo('----- The new console call ----------');

// Простые php функции из папки /core/functions/ вставляем вручную
if(!function_exists('insert_function')){
	$log->LogDebug('Trying to call insert_function_function.php');
	@include_once $_SERVER['DOCUMENT_ROOT'].'/core/insert_function_function.php';// Вызов: insert_function("functionname")
}
if(!function_exists('insert_module')) {
	$log->LogDebug('Trying to insert insert_module function');
	include $_SERVER['DOCUMENT_ROOT'].'/core/insert_module_function.php';
}

$log->LogDebug('Trying to check available modules');
include($_SERVER['DOCUMENT_ROOT'].'/core/check_avail_modules.php');
?>