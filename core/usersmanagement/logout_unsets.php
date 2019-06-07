<?php # Уничтожает переменные сессии
# Разрегистрируем переменные
$log->LogInfo('Got this file');
unset($_SESSION['login']);
unset($_SESSION['password']);
unset($_SESSION['log']);
unset($_SESSION['userrole']);
unset($_SESSION['nickname']);
unset($_SESSION['company_id']);
unset($_SESSION['fullname']);
unset($_SESSION['changepassmust']);
unset($_SESSION['template']);?>