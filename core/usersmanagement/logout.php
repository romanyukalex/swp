<?php # Уничтожает переменные сессии
# Разрегистрируем переменные
$log->LogInfo('Got this file');
@include_once($_SERVER['DOCUMENT_ROOT']."/core/usersmanagement/logout_unsets.php");
$_SESSION = array();
session_unset();
session_destroy();// уничтожаем сессию
@include_once($_SERVER['DOCUMENT_ROOT']."/core/system-param.php");
@include_once($_SERVER['DOCUMENT_ROOT']."/core/messages.php");
?><span style='color:green' id="logout_message_place" style="visibility:hidden "><?=$sitemessage["system"]["logout_complete"];?></span>
<script>$(document).ready(function(){openlogin();showmenu('mainmenu','leftmenutab');becamebig('logout_message_place').changerazdel('login').closeblock('logout_message_place');});</script>