<?php
/*$code = get_html_code_url("popwebstudio.ru"); // Скачиваю код страницы
if( is_numeric($content)){echo "Ошибка ".$content;}
echo htmlspecialchars($code); // Вывожу на экран*/
function get_html_code_url($url,$proxy=NULL, $useragent=NULL,$cookie=NULL) {
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
    $curl = curl_init(); // Инициализирую CURL
    curl_setopt($curl, CURLOPT_HEADER, 0); // Отключаю в выводе header-ы
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //Возвратить данные а не показать в браузере
    curl_setopt($curl, CURLOPT_URL, $url); // Указываю URL
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_REFERER, $url);
	
	
	#Для Cookie, проверить
	//curl_setopt($curl, CURLOPT_POST, 0);
	//curl_setopt($curl, CURLOPT_COOKIESESSION,TRUE);
	#Пишем куки в файл
	//curl_setopt($curl, CURLOPT_COOKIEFILE,   $_SERVER["DOCUMENT_ROOT"]."/cookies1.txt"); 
	//curl_setopt($curl, CURLOPT_COOKIEJAR,  $_SERVER["DOCUMENT_ROOT"]."/cookies1.txt"); 
	#если добавили куки, присоединяем их
	if (strlen($cookie)>0) curl_setopt($curl, CURLOPT_COOKIE, $cookie);

	//устанавливаем реферер
	//curl_setopt($curl, CURLOPT_REFERER, 'https://yandex.ru');
    if($proxy){
        curl_setopt ($curl, CURLOPT_PROXY, $proxy); 
        curl_setopt ($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
    }
	if($useragent) curl_setopt($curl, CURLOPT_USERAGENT, $useragent);
    $code = curl_exec($curl); // Получаю данные
    if (!curl_errno($curl)) {
        switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
			case 200:  # OK
				break;
			default:
			 $log->LogError('Unknown HTTP code: '. $http_code.'. Params were:'.implode(',',func_get_args())); return $http_code.$code;
		}
	} else {
		echo curl_errno($curl);
	}
    curl_close($curl); // Закрываю CURL сессию
    $log->LogDebug("Size of received code - ".mb_strlen( $code));
	
    return $code;
}?>
