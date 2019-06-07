<? # постит данные куда хочешь
$log->LogInfo("Got this file");
function postdata($destinationip,$destinationport,$scriptpath,$posts){
	global $log;
    $log->LogDebug(basename (__FILE__)." | Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	$fp = fsockopen($destinationip, $destinationport, $errno, $errstr, 30);
	if($fp){# Формируе м запрос в открытый сокет
		$request = "POST http://".$destinationip."/".$scriptpath." HTTP/1.1\r\n";
		$request .= "Host: $destinationip\r\n";
		$request .= "Content-Type: application/x-www-form-urlencoded\r\n"."Content-Length: ".strlen($posts)."\r\n\r\n". $posts."\r\n\r\n";
		$request .= "Connection: Close\r\n";
		$request .= "\r\n";
		fwrite($fp, $request);
		fclose($fp);
	}
}