<?php 
# Функция переводит через яндекс пеерводчик и определяет язык текста
/* //Пример
$apikey='trnsl.1.1.20171128T145527Z.fd2d0fd54dcf65d8.dcc32755f10fb041009f6e0cf185858f5500759d';
$text=$pagdata['pagetitle_ru'];
$lang='ru-en';
if($en_text=translateViaYandex ($apikey,$text,$lang)) {
	echo "<br>Перевод - ".$en_text;
} else echo "FALSE";
*/
function translateViaYandex ($apikey,$text,$lang){
	global $log;
	$log->LogInfo("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	$data = array(
		'key' => $apikey, //https://translate.yandex.ru/developers/keys
		'text' => $text,
		'lang' => $lang,
		'format' => 'plain',
		'options' => 1,
	);

	$curlObject = curl_init();
	 
	curl_setopt($curlObject, CURLOPT_URL, 'https://translate.yandex.net/api/v1.5/tr.json/translate');
	 
	curl_setopt($curlObject, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curlObject, CURLOPT_SSL_VERIFYHOST, false);
	 
	curl_setopt($curlObject, CURLOPT_POST, true);
	curl_setopt($curlObject, CURLOPT_POSTFIELDS, http_build_query($data,'','&'));
	 
	curl_setopt($curlObject, CURLOPT_RETURNTRANSFER, true);
	 
	$responseData = curl_exec($curlObject);
	 
	curl_close($curlObject);
	 
	if ($responseData === false) {
		$log->LogError("Response false");
		return false;
	}
	$log->LogInfo("Yandex answered");
	
	
	$answer_arr=json_decode($responseData, true);
	if($answer_arr['code']=="200") {
		return $answer_arr["text"][0];
	} else return false;
}

function getTextLanguage($apikey,$text,$hint){ //hint - вероятные языки через запятую
		$data = array(
		'key' => $apikey, //https://translate.yandex.ru/developers/keys
		'text' => $text,
		'hint' => $hint,
		'format' => 'plain',
		'options' => 1,
	);

	$curlObject = curl_init();
	 
	curl_setopt($curlObject, CURLOPT_URL, 'https://translate.yandex.net/api/v1.5/tr.json/detect');
	 
	curl_setopt($curlObject, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curlObject, CURLOPT_SSL_VERIFYHOST, false);
	 
	curl_setopt($curlObject, CURLOPT_POST, true);
	curl_setopt($curlObject, CURLOPT_POSTFIELDS, http_build_query($data,'','&'));
	 
	curl_setopt($curlObject, CURLOPT_RETURNTRANSFER, true);
	 
	$responseData = curl_exec($curlObject);
	 
	curl_close($curlObject);
	 
	if ($responseData === false) {
		$log->LogError("Response false");
		return false;
	}
	 
	$answer_arr=json_decode($responseData, true);
	if($answer_arr['code']=="200") {
		return $answer_arr["lang"];
	} else return false;
}


?>