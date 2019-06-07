<? // Функция возвращает 1, если адрес указан неверно и 0, если все порядке.
function CheckDomain($Domain){
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
    if (@getmxrr($Domain, $MXHost)) return 0;
    else {
        $f=@fsockopen($Domain, 25, $errno, $errstr, 30);
        if($f){
            fclose($f);
            return 0;
        } else return 1;
    }
}
function check_http_status($url)
  {
  global $log;
  $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
  $user_agent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0)';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_VERBOSE, false);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSLVERSION, 3);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  $page = curl_exec($ch);

  $err = curl_error($ch);
  if (!empty($err))
    return $err;
  
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
  $log->LogDebug('Code is '.$httpcode);
  if($httpcode!==200){
	  
	  $log->LogDebug('Details:'.
	  ' CURLINFO_OS_ERRNO - '.curl_getinfo($ch, CURLINFO_OS_ERRNO).';'.
	  ' CURLINFO_EFFECTIVE_URL - '.curl_getinfo($ch,CURLINFO_EFFECTIVE_URL).';'.
	  ' CURLINFO_NUM_CONNECTS - '.curl_getinfo($ch,CURLINFO_NUM_CONNECTS ).';'.
	  ' CURLINFO_COOKIELIST - '.curl_getinfo($ch,CURLINFO_COOKIELIST ).';'.
	  ' CURLINFO_HTTP_CONNECTCODE - '.curl_getinfo($ch,CURLINFO_HTTP_CONNECTCODE).';'.
	  ' CURLINFO_SSL_VERIFYRESULT  - '.curl_getinfo($ch,CURLINFO_SSL_VERIFYRESULT ).';'.
	  ' CURLINFO_REDIRECT_URL - '.curl_getinfo($ch,CURLINFO_REDIRECT_URL).';'.
	  ' CURLINFO_REDIRECT_COUNT - '.curl_getinfo($ch,CURLINFO_REDIRECT_COUNT ).';'
	  );
  }
  curl_close($ch);
  return $httpcode;
  }

/*$url = 'http://obovsem.org.ua/';
$answer = check_http_status($url);
echo 'Код статуса HTTP: '.$answer.'. Ответ на запрос URL: '.$url;*/
?>