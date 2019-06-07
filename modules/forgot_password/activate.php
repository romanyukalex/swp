<? 
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if($_REQUEST['action']=="activate" and $nitka=="1"){
	include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/core/system-param.php");
	$activationlink=process_data($_REQUEST['activationlink'],15);
	
	$user=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` u,`$companiesprefix-companies` c WHERE `ActivationLink`='$activationlink' and u.`company_id`=c.`company_id`LIMIT 0 , 1"));

	
	?><div id="forgotpassform_answer"><?
	if($user['userid']){// Пользователь найден
		insert_function("abracadabra");
		$randompass=abracadabra(32,"mix");
		$randompassmd5=md5($randompass);
		$activateuserreq=mysql_query("UPDATE `$tableprefix-users` SET `status` = 'active',`ActivationLink` = '',`DeactivationLink` = '',`password`='$randompassmd5' WHERE `userid` ='$user[userid]';");
		if($activateuserreq){ // Активирован
		?>
		<h1>Пароль успешно сброшен:</h1>
		<? //include_once($_SERVER["DOCUMENT_ROOT"]."/modules/.php");
		$pageshtrih="login";
		insert_module("change_password");
		?>
		<script>$(document).ready(function(){ 
			$("#old_password").val('<?=$randompass?>').hide();
			$("#changepassmode").val('2');
			$("#cpuserid").val('<?=$user['userid']?>');
		});</script>
		<?
		}
	} else {?><h1>Пароль не сброшен:</h1>
	<p>Неправильная строка активации или пароль уже был сброшен с использованием данной строки активации ранее.</p>
<?	}
	?></div><?
}
?>