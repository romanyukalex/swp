<? # Скрипт, принимающий все ajax запросы от пользователей
session_start();
Header('Cache-Control: no-cache, must-revalidate'); Header('Pragma: no-cache');
$ajaxflag=1;
$block=null;
@include($_SERVER['DOCUMENT_ROOT'].'/core/projectname.php');
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/system-param.php');#Параметры портала, юзер сеттинги
if($_REQUEST['mod']=='adminpanel') $adminpanel=1; # Чтобы логи были в правильном файле, пишем это здесь
@include($_SERVER['DOCUMENT_ROOT'].'/core/functions/KLogger.php');
if ($adminpanel==1) {
	$log=new KLogger( $ap_logfile , $ap_loglevel);
} elseif($nitka==1) {
	$log=new KLogger( $logfile , $loglevel);
}
$log->LogInfo('------ The new ajax request ------');
$comma_separated_req=null;
foreach ($_REQUEST as $Key => $Value) $comma_separated_req .= $Key . '=' . $Value.';';
$log->LogDebug('REQUEST parameters: '.$comma_separated_req);
include($_SERVER['DOCUMENT_ROOT'].'/core/check_ajax.php'); // Проверяем, ajax ли
include_once $_SERVER['DOCUMENT_ROOT'].'/core/insert_function_function.php';
//insert_function('insert_module');
include $_SERVER['DOCUMENT_ROOT'].'/core/insert_module_function.php';
$log->LogDebug('Trying to check available modules');
@include($_SERVER['DOCUMENT_ROOT'].'/core/check_avail_modules.php');
$log->LogDebug('Trying to get mode from get');
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/modefromget.php');#Определение $mode
if($block!==1){
	insert_function('process_user_data');
	@include_once($_SERVER['DOCUMENT_ROOT'].'/core/templatefromget.php');#Определение $sitetemplate, выбираются правильные месседжи
	@include_once($_SERVER['DOCUMENT_ROOT'].'/core/messages.php');#Все сообщения портала
	if($_REQUEST['action']){
		$requestaction=process_data($_REQUEST['action'],50);
		$log->LogInfo('Action in request: '.$requestaction);
		}
	if ($_REQUEST['mod']){# Вызов от какого то модуля
		if ($modulename=process_data($_REQUEST['mod'],50)){$log->LogInfo('We got modulename in request equal '.$_REQUEST['mod']);;}
		if($modulename=='usersmanagement'){
			$log->LogDebug('Trying to call usersmanagement/ajax.php');
			include($_SERVER['DOCUMENT_ROOT'].'/core/usersmanagement/ajax.php');
		}
		elseif($modulename=='adminpanel'){
			$log->LogDebug('Trying to call adminpanel-ajaxactions.php');
			include($_SERVER['DOCUMENT_ROOT'].'/adminpanel/adminpanel-ajaxactions.php');
		} elseif($modulename=='project_script'){
			$log->LogDebug('Trying to call /project/'.$projectname.'/scripts/project-ajax.php');
			include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/project-ajax.php');
		}
		else {
			
			if(is_readable($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/controller.php')) {
				if(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
				include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/controller.php'); 
				# Расширение контроллера модуля, специфичное для проекта
				if(is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$modulename.'.controller.php')) include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$modulename.'.controller.php');
				# Показываем view, если его вызвали
				include($_SERVER['DOCUMENT_ROOT'].'/core/mvc_get_module_view.php');
				die();
			}
			
			
			
			
			
			
			$log->LogDebug('Trying to call '.$modulename.'/ajax.php');
			include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/config.php');
			include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/ajax.php');
		}

	} elseif ($requestaction=='getpage'){# Показываем страничку
		$log->LogDebug('Trying to call pagemanage.php');
		include($_SERVER['DOCUMENT_ROOT'].'/core/pagemanage.php');
		}
	elseif ($requestaction=='checklogin')
		{# Пользователь логинится (перенести в usermanagement)
		$log->LogDebug('Trying to check userrole');
		include($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); // Определяем userrole
		if($showmessage){$log->LogDebug('Message has been shown: '.$showmessage);
			echo "<span style='color:".$messagecolor."'>".$showmessage.'</span>';
			if ($userrole!=='guest' and isset($userrole)) echo "<br><br><a href='/logout/' onclick='logout();return false;'>Покинуть кабинет</a>";
		}
		if(isset($userrole) and $userrole!=='guest'){?><script>
			closelogin();showmenu('cabinet','leftmenutab');changerazdel('cabinet');
		$(document).ready(function(){closelogin();showmenu('cabinet','leftmenutab');changerazdel('cabinet');
		});</script><? }
		unset($showmessage);unset($messagecolor);
		}
	elseif($_REQUEST['action']=='logout')
		{
		include($_SERVER['DOCUMENT_ROOT'].'/core/usersmanagement/logout.php');
		?><script>$(document).ready(function(){openlogin();showmenu('<?=$defaultmenu?>','leftmenutab');changerazdel('login');});</script><?
		}
	elseif($requestaction=='saveform'){ // Перенести в adminpanel-ajaxactions
		include($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); // Определяем userrole
		if($_REQUEST['someid']=='create_user'){include($_SERVER['DOCUMENT_ROOT'].'/core/usersmanagement/ajax.php');// Безобразие
		}
	}
	elseif($requestaction=='ajax_error_handled'){ # Логгер для ошибок Ajax
		$log->LogError('Ajax error is handled: '.$_REQUEST['data']);
	}
	else{echo 'Неизвестный тип действия (action unknown)';} // Сделать sitemessage
 } else $log->LogFatal('The type of request is not ajax. Query was blocked');
 $log->LogDebug('------ // The end of ajax request ------');?>