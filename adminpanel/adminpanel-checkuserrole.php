<? 
/************************************************************************************
* Snippet Name : adminpanel-checkuserrole.php										*															
* Scripted By  : RomanyukAlex		           										*														
* Website      : http://popwebstudio.ru	   											*				 
* Email        : admin@popwebstudio.ru    					 						* 
* License      : License on popwebstudio.ru from autor		 						*
* Purpose 	 : Процесс аутентификации юзера администраторского веб-интерфеса		*
* Insert		 : include_once('adminpanel-checkuserrole.php');					*  
************************************************************************************/ 
$log->LogInfo("Got ".(__FILE__));
if($adminpanel==1){
//Определяем тип запроса
//if (!isset($_SESSION['login'])){//В сессионных куках юзера нету переменной login
//echo "1";
if (isset($_REQUEST['login'])){
$userrole="guest";
$login=process_data($_REQUEST['login'],40);
$password=process_data($_REQUEST['password'],40);
$cook=process_data($_POST['cook'],20);
$Family= substr($_POST['Family'],0,1);
//echo "login=".$login;
if ($login or $password)
{//Что то пришло
//Отрежем пробелы
$login=trim($login);$password=trim($password);$Family=trim($Family);
//Проверка полученного:
/// Все ли данные передались/передали?
$errmessage="";$err=0;
if (empty($login) or empty($password)) 
		{/*Если чтото из них пустое - это не все поля заполнил юзер или ошибка на сети. */
	 	$err=1;
		}
if (!preg_match('/^([A-Za-z0-9])+$/',$login))	
		{
		$err=2;
		}
if (!preg_match('/^([A-Za-z0-9])+$/',$password))
	{//Содержит плохие знаки
	$err=3;
	}
if(!$Family=="") 
		{//Это ловушка для роботов.Робот бы заполнил
		$err=6;
		};
if ($err!==0)
	{//Проверка формата пройдена неуспешно
	if ($err==1){$errmessage="Заполните все поля";}
	elseif ($err==2){$errmessage="Логин должен состоять из цифр и/или английских букв";}
	elseif ($err==3){$errmessage="Пароль должен состоять из цифр и/или английских букв";}
	elseif ($err==6){$errmessage="Подделка параметров сессии(1)";}
	else 			{//$err непонятно откуда взялся
					$errmessage="Подделка параметров сессии(2)";}
	$userrole="guest";
	echo "err=".$err;
	}
else{
	//echo "2";
	//Проверка формата пройдена успешно,поиск юзера
	$errmessage="";
	$showmessage="";
	require_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
	$userquery=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users-admin` WHERE `login`='$login' and `password`='$password' limit 0,1;"));
	if($userquery['userrole'])
		{# Аутентифицировали
		$userrole=$_SESSION['userrole']=$userquery['userrole'];
		$userid=$_SESSION['userid']=$userquery['userid'];
		$_SESSION['login']=$login;
		$_SESSION['password']=$password;
		$nickname=$_SESSION['nickname']=$userquery['nickname'];
		$fullname=$_SESSION['fullname']=$userquery['fullname'];
		$changepassmust=$_SESSION['changepassmust']=$userquery['changepassmust'];
		if($nickname){$showmessage="Добро пожаловать, ".$nickname;}
		elseif($fullname){$showmessage="Добро пожаловать, ".$fullname;}
		$messagecolor="green";
		if($userquery['changepassmust']=="2")
			{// Юзер должен поменять пароль
			$changepassmust=$_SESSION['changepassmust']="yes";
			$showmessage.="<br>Пожалуйста, измените Ваш пароль";
			//include($_SERVER['DOCUMENT_ROOT']."/modules/change_password/design.php");
			//insert_module("change_password");
			}
		$_SESSION['log']="1"; // Признак залогиненности
		# Получаем все rights юзера по userid
		$userrightsreq=mysql_query("SELECT DISTINCT * FROM `$tableprefix-users-admin` u,
		`$tableprefix-users-groupmembers` gm,`$tableprefix-users-grouprights` gr
		WHERE u.`userid`=gm.`userid` and gr.`group_id`=gm.`group_id` and	u.`userid`='$userid'");
		}
	else{//Нет такого юзера
		$showmessage="Неправильно введены логин/пароль";$messagecolor="red";
		$userrole="guest";
		}
	}
}	
}
elseif($_SESSION['log']=="1") {//В сессионных куках юзера есть данные о юзернейме
$login=$_SESSION['login'];
$userid=$_SESSION['userid'];
$password=$_SESSION['password'];
$userrole=$_SESSION['userrole'];
$nickname=$_SESSION['nickname'];
$fullname=$_SESSION['fullname'];
$changepassmust=$_SESSION['changepassmust'];
# Получаем все rights юзера по userid
$userrightsreq=mysql_query("SELECT DISTINCT * FROM `$tableprefix-users-admin` u,
`$tableprefix-users-groupmembers` gm,`$tableprefix-users-grouprights` gr
WHERE u.`userid`=gm.`userid` and gr.`group_id`=gm.`group_id` and	u.`userid`='$userid'");
}}