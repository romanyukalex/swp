<?php
/**
* Дёрнуть триггер сервиса https://maker.ifttt.com.

// Получить ключ - https://ifttt.com/services/maker_webhooks/settings

insert_function("ifttt");
$ifttt_param=array(
	'key'=>'hnMEpWRtP-vy8mY0mbhvxzyYvVDxYRtzTVzr2SJ1U6d',
	'trigger'=>'facebookit',
	'params'=>array(
		'value1' => 'https://soznanie.club/?page=prichiny-suicida-u-podrostkov',
		'value2'=>'ДАДАДА2'
	)
);

if(ifttt_trigger($ifttt_param)) echo "trigger OK";
else echo "trigger NOK!";

*/
function ifttt_trigger($ifttt_param){
	
	$ch = curl_init ();
	curl_setopt ($ch, CURLOPT_POST, true);
	curl_setopt ($ch, CURLOPT_URL, 'https://maker.ifttt.com/trigger/'.$ifttt_param['trigger'].'/with/key/'.$ifttt_param['key']);
	curl_setopt ($ch, CURLOPT_USERAGENT, 'cURL/php');
	curl_setopt ($ch,CURLOPT_HTTPHEADER,'Content-Type: application/json');
	curl_setopt($ch,CURLOPT_POSTFIELDS, $ifttt_param['params']);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$curl_res=curl_exec ($ch);
	if(strstr($curl_res,'Congratulations! You')) return TRUE;
	else return FALSE;
}?>
