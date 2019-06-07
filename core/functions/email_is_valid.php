<? # Функции для проверки правильности введения емейла (для старых PHP)
$log->LogInfo('Got this file');
function email_is_valid($email, $test_mx = false) {
	global $log;
	$log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	if(eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
		if($test_mx){
			list($username, $domain) = split("@", $email);
			return getmxrr($domain, $mxrecords);
		}
		else return true;
	}
	else return false;
}?>