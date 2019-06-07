<?php # Уничтожает переменные сессии
//Это не ajax, надо открыть механизм сессий
$logoutflag=1;
$nitka=1;
@require($_SERVER['DOCUMENT_ROOT']."/core/projectname.php");
require($_SERVER['DOCUMENT_ROOT']."/core/system-param.php");

@include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts.php');

$log->LogInfo('Got '.(__FILE__));

session_start();

include_once($_SERVER['DOCUMENT_ROOT']."/core/usersmanagement/logout_unsets.php");

session_destroy();// уничтожаем сессию
// Перенаправляем заголовок
include($_SERVER['DOCUMENT_ROOT']."/core/system-param.php");
$thishost=$_SERVER['HTTP_HOST'];
if($pageafterlogout) header("Location: http://".$thishost."/?page=".$pageafterlogout);
else header("Location: http://".$thishost."/");
?>