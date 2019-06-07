<?php
 /****************************************************************
  * Snippet Name : isSiteAvailable		           				 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : Проверка работоспособности сайта на CURL		 *
  * Access		 : $response = isSiteAvailable($someUrl); 		 *
  * 1 - site is available
  * 2 - URL недоступен или такого домена не существует
  * 3 - Вы ввели неверный URL 
  ***************************************************************/
$log->LogInfo('Got this file');

function isSiteAvailable($url) {
	global $log;
	$log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
    // проверка на валидность представленного url
    if(!filter_var($url, FILTER_VALIDATE_URL)) {
		$log->LogDebug("Incorrect URL");
		return 3;
    }
 
    // создаём curl подключение
    $cl = curl_init($url);
    curl_setopt($cl,CURLOPT_CONNECTTIMEOUT,10);
    curl_setopt($cl,CURLOPT_HEADER,true);
    curl_setopt($cl,CURLOPT_NOBODY,true);
    curl_setopt($cl,CURLOPT_RETURNTRANSFER,true);
    // получаем ответ
    $response = curl_exec($cl);
    curl_close($cl);
    if ($response) {
		$log->LogDebug("URL is available");
		return 1;
	}
	$log->LogDebug("URL is unavailable or domain is not exist");
    return 2;
}?>