<?
if ($nitka=="1"){
	insert_function("send_letter");
	global $sitedomainname,$subject,$newordermailnotify;
	$msubject="[".$sitedomainname."] ".$subject." ".$_REQUEST['10']." ".$_REQUEST['1'];
	$mail_message="
	<html>
	<body>
	<table><tr><td>
	<img src='http://".$sitedomainname.$logofile."' width='128px'>
	</td><td>
	<h2>Зарегистрирован новый пользователь</h2>
	</td></tr></table>
	<br>
		<p style='margin:0 auto;'>
		<h4>Введенные данные</h4><br><br>
		<table><tr><td>
		Фамилия и Имя:<br>
		Емейл:<br>
		Телефон:<br>
		Сумма:<br>
		Обработка персональных данных:<br>
		Время:<br>
		Источник:<br>
		Событие:
		</td><td>
		".$_REQUEST['10']." ".$_REQUEST['1']."<br>
		".$_REQUEST['9']."<br>
		".$_REQUEST['4'].$_REQUEST['7'].$_REQUEST['8']."<br>
		".$_REQUEST['price']."<br>";
		if($_REQUEST['5']=='1')$mail_message.="Согласен"; else $mail_message.="Не согласен"; 
		$mail_message.="<br>".date('Y-m-d H:i');
		$mail_message.="<br>";
		if($_REQUEST['goads']){$mail_message.="Рекламное объявление Google №".$_REQUEST['goads'];}
		elseif($_REQUEST['yaads']){$mail_message.="Рекламное объявление Yandex №".$_REQUEST['yaads'];}
		elseif($_REQUEST['vk']){$mail_message.="Рекламное объявление VK от аккаунта ";
			if($_REQUEST['vk']=="a") $mail_message.="Алексея";
			elseif($_REQUEST['vk']=="d") $mail_message.="Дмитрия";
		}
		else{$mail_message.="Не определен";}
		if($_REQUEST['action_id']){
			$act_data=insert_module("actions", "get_actions_data_by_action_id",$_REQUEST['action_id']);
			$action_data=mysql_fetch_array($act_data);
			$mail_message.="<br>".$action_data['type_title_'.$language]." (".$action_data['type_code']."): ".$action_data['act_title']." (ID=".$action_data['act_id'].")";
		}
		$mail_message.="</td></tr></table>

		</p>
		<p>
		<hr>
		С уважением и признанием Ваших заслуг перед отечеством и проектом ".$sitedomainname."<br>Автоматический скрипт<br><br><small style='color:red'>Не отвечайте на это письмо</small></p>
	</body>
	
	</html>
	
	";
	sendletter($newordermailnotify,$msubject,$mail_message);
	#Создадим счёт
	$new_user_id=mysql_insert_id();
	mysql_query("INSERT INTO `$tableprefix-account` (`ac_id`, `user_id`, `items`, `currency`, `comment`) VALUES (NULL, '$new_user_id', '0', 'занятие', '');");
	
	#INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`) VALUES (NULL, 'admin@domain.com', 1, 'Емейл для нотификации о регистрации нового пользователя', 'newordermailnotify', 200, NULL, 1, NULL, 'user', 1);
}?>