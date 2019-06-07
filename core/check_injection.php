<?
// Проверим url на иньекции
$log->LogInfo('Got this file');
//$req  =  $_SERVER['REQUEST_URI'];
$cadena = explode('?', $_SERVER['REQUEST_URI']);
$inyecc='/script|http|<|>|%3c|%3e|SELECT|UNION|UPDATE|.exe|.exec|passwd|INSERT|tmp/i'; 
if (preg_match($inyecc, $cadena[1] )){
	include($_SERVER['DOCUMENT_ROOT'].'/core/IPreal.php');
	$log->LogError('Attack injection in "'.$_SERVER['REQUEST_URI'].'" from: '.$ip);
	if($injection_act=='Не отображать страницу' or $injection_act=='Не отображать страницу и оповестить администратора') $block=1;
	if($injection_act=='Отправить письмо администратору' or $injection_act=='Не отображать страницу и оповестить администратора'){
		
		$message = 'Attack injection in '.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'<br>
		'.urldecode($_SERVER['REQUEST_URI']).'<br>
		IP: '.$ip.' '.$_SERVER['REMOTE_HOST'].'<br>
		USER AGENT: '.$_SERVER['HTTP_USER_AGENT'].'<br><br>
		
		--------- Yours SWP ---------------<br><br><br>
		All data:<br>';
		foreach($_SERVER as $key=>$value){
			$message .= $key.': '.$value.'<br>';
		};
		insert_function('send_letter');
		sendletter_to_admin('Attack injection '.$sitedomainname,$message);
	
	}
}
?>