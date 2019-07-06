<?php
 /***************************************************************************
  * Snippet Name : change password (ajax part) 					 			* 
  * Scripted By  : RomanyukAlex		           					 			* 
  * Website      : http://popwebstudio.ru	   					 			* 
  * Email        : admin@popwebstudio.ru     					 			* 
  * License      : GPL (General Public License)					 			* 
  * Purpose 	 : Проверяет пришедшие данные на смену пароля и меняет его	*
  * Access		 : include									 	 			*
  ***************************************************************************/
$log->LogInfo("Got ".(__FILE__));
if ($nitka=="1"){  
include_once($_SERVER["DOCUMENT_ROOT"]."/core/checkuserrole.php"); // Определяем userrole
include_once($_SERVER["DOCUMENT_ROOT"]."/core/system-param.php"); 
if(($userrole!=="guest" and $userrole and $_REQUEST['changepassmode']=="1")or $_REQUEST['changepassmode']=="2"){

	$newpassword1=process_data($_REQUEST['new_password1'],40);
	$newpassword2=process_data($_REQUEST['new_password2'],40);
	$oldpassreqst=process_data($_REQUEST['old_password'],40);
	if($_REQUEST['changepassmode']=="1") $oldpassreal=$_SESSION['password'];
	if (!$newpassword1 and !$newpassword2){
		//$showmessage="Заполните все обязательные поля";
		$showmessage=sitemessage("$modulename","fill_all_required");
		$messagecolor="red";
		}
	elseif($newpassword1!==$newpassword2){
		$showmessage=sitemessage("$modulename","new_passes_not_equal");// Присланные пароли не совпадают
		$messagecolor="red";
	}
	elseif($oldpassreqst!==$oldpassreal and $_REQUEST['changepassmode']=="1"){
		$showmessage=sitemessage("$modulename","wrong_cur_pass");//Вы указываете неверный текущий пароль
		$messagecolor="red";
	}
	elseif($newpassword1==$oldpassreal){
		$showmessage=sitemessage("$modulename","cur_pass_equal_new_pass");//Вы не сменили пароль
		$messagecolor="red";
	}
	else{ // Пришли
		$newpassword=$_REQUEST['new_password2'];
		include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
		if(!$userid) $userid=$_SESSION['userid'];
		# Проверка истории паролей
		if($passhistdepth>0){ # Проверять историю надо
			#Запрос истории паролей
			if ($userid<1000){ $user_info=mysql_fetch_array(mysql_query("SELECT `password_history` FROM `$tableprefix-users-admin` where `userid`='$userid';"));
			} elseif($userid>=1000) {$user_info=mysql_fetch_array(mysql_query("SELECT `password_history` FROM `$tableprefix-users` where `userid`='$userid';"));
			}
			#Разбиваем ее на отдельные штуки
			$oldest_pass=explode(";",$user_info['password_history']);
			for($phn=count($oldest_pass);$phn>(count($oldest_pass) - $passhistdepth);$phn--){
				if($oldest_pass[$phn]==$newpassword){ # Не меняем пароль, тк его уже использовали на этой глубине
					$dontchangepass=1;
				}
			}
		}
		if ($userid<1000 and $dontchangepass!==1){#Меняем пароль админу
			$changepassreq=mysql_query("UPDATE `$tableprefix-users-admin` SET `password_history`=CONCAT(`password_history`,`password`,';'),`password` = '$newpassword',`changepassmust`='1',`passw_last_change_date` =  CURDATE() WHERE `userid` = $userid;");
		} elseif($userid>=1000 and !$dontchangepass==1){	# Меняем пароль простого пользователя	if($_REQUEST['changepassmode']=="1") {// Меняет пасс зарегистрированный пользователь
			if($_REQUEST['changepassmode']=="1") {// Меняет пасс зарегистрированный пользователь
				if($authlogin=='only_login') {$loginphrase="`login`='$login'";}
				elseif($authlogin=='only_email') {$loginphrase="`contactmail`='$login'";}
				elseif($authlogin=='both') {$loginphrase="(`login`='$login' or `contactmail`='$login')";}		
			}
			elseif($_REQUEST['changepassmode']=="2") {//Забывчивый пользователь
				$needuserid=process_data($_REQUEST['userid'],20);
				$loginphrase="`userid`='$needuserid'";
			}
			$changepassreq=mysql_query("UPDATE `$tableprefix-users` SET `password_history`=CONCAT(`password_history`,`password`,';'),`password` = '$newpassword',`changepassmust`='1',`passw_last_change_date` =  CURDATE() WHERE $loginphrase;");

		}
		if($changepassreq) {// Пароль изменен
			if($_REQUEST['changepassmode']=="1"){ 
				$_SESSION['password']=$newpassword; 
				unset($_SESSION['changepassmust']);
			}
			$successpage=process_data($_REQUEST['successpage'],20);
			?><script>$(document).ready(function(){clearchangeform();
				$('#changepassform').fadeOut(800);
				setTimeout(function(){changerazdel("<?=$successpage?>")}, 5000);
				});
			</script><?
			$messagecolor="green";$showmessage=sitemessage("$modulename","pass_changed_succ");//"Пароль успешно изменен"
		} elseif($dontchangepass==1) {$messagecolor="red"; $showmessage=sitemessage("$modulename","new_pass_already_used");// Устанавливаемый пароль уже использовался ранее
		} else {$messagecolor="red";$showmessage=sitemessage("$modulename","password_wasnt_changed");//"Пароль не был изменен";
		}
	}
	echo "<span style='color:".$messagecolor."; font-size:bold'>".$showmessage."</span>";
}
elseif($_REQUEST['action']=="change_password_page"){echo "!23!";
	
	@require_once($_SERVER["DOCUMENT_ROOT"]."/core/check_avail_modules.php");
	insert_function("insert_module");
	insert_module("change_password");
}
?>
<? } ?>