<? # Функция убирает ссылки вида http://somelink.ru из текста

$log->LogInfo('Got this file');
function clean_url_from_text($text){ 
	global $log;
	//$log->LogDebug('Called '.(__FUNCTION__).' function with params: '.implode(',',func_get_args()));
	
	$U = explode(' ',$text);

  $W =array();
  foreach ($U as $k => $u) {
    //if (stristr($u,'http') || (count(explode('.',$u)) > 1)) {
	if (stristr($u,'http')) {
      unset($U[$k]);
    //  return clean_url_from_text( implode(' ',$U));
    }
  }
  return implode(' ',$U);
}

// Или так - $string = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $string);