<? # Проверяет, аяксовый ли запрос или нет
$log->LogInfo('Got this file');
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {//Это ajax запрос!
	$log->LogDebug('This is true ajax request');
	$gettype='ajax';
}
else{
	$log->LogError('Non-ajax request received');
	$block=1;
}
?>
