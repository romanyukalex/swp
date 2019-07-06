<?
if ($nitka=="1"){
	insert_function("send_letter");
	global $sitedomainname,$subject,$newordermailnotify;
	$msubject="[".$sitedomainname."] ".$subject;
	$mail_message="
	<html>
	<body>
	<table><tr><td>
	<img src='http://summer-quest.ru/files/!yellowShoe.png' width='128px'>
	</td><td>
	<h2>Новый пользователь зарегистрирован</h2>
	</td></tr></table>
	<br>
		<p style='margin:0 auto;'>
		<h4>Введенные данные</h4><br><br>
		<table><tr><td>
		Фамилия и Имя:<br>
		Город:<br>
		Телефон:<br>
		Портал:<br>
		Обработка персональных данных:<br>
		Время:
		</td><td>
		".$_REQUEST['2']." ".$_REQUEST['1']."<br>
		".$_REQUEST['3']."<br>
		".$_REQUEST['4'].$_REQUEST['7'].$_REQUEST['8']."<br>
		".$_REQUEST['6']."<br>";
		if($_REQUEST['5']=='1')$mail_message.="Согласен"; else $mail_message.="Не согласен"; 
		$mail_message.="<br>".date('Y-m-d H:i');
		$mail_message.="<br>
		</td></tr></table>

		</p>
		<p>
		<hr>
		С уважением и признанием Ваших заслуг перед отечеством и проектом ".$sitedomainname."<br>Автоматический скрипт<br><br><small style='color:red'>Не отвечайте на это письмо</small></p>
	</body>
	
	</html>
	
	";
	sendletter($newordermailnotify,$msubject,$mail_message);
}?>