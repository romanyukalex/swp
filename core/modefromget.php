<? # Определяет какой режим работы сайта запрашивает пользователь
$log->LogInfo('Got this file');
include_once($_SERVER['DOCUMENT_ROOT'].'/process_user_data.php');
unset ($mode);
if ($_SESSION['mode']=='debug') $mode='debug';
if ($_REQUEST['mode'] and process_data($_REQUEST['mode'],7)==$debugmoderequestparam) 
	{$mode='debug';$_SESSION['mode']='debug';}
elseif($_REQUEST['mode'] and process_data($_REQUEST['mode'],7)!==$debugmoderequestparam){
	$mode='nodebug';$_SESSION['mode']='nodebug';
}
?>