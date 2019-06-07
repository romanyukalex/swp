<?php # Проверяет попадает ли IP адрес пользователя в ренж разрешенных ip адресов или совпадает ли он с разрешенным single ip
$log->LogInfo('Got this file');
function ipinrange ($valid_ip_address,$ip){
	global $log;
	$log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	if(ereg("-",$valid_ip_address)) {// Это range адресов
		$ar = explode("-",$valid_ip_address);
		$your_long_ip = ip2long($ip);
		if ( ($your_long_ip >= ip2long($ar[0])) && ($your_long_ip <= ip2long($ar[1]))){
			$log->LogDebug("IP is in valid range");
			return TRUE;
		}
	}
	else{// Single IP
		if ($ip==$valid_ip_address){
			$log->LogDebug("IP is in valid range");
			return TRUE;
		}
	}
	$log->LogDebug("IP is NOT in valid range");
	return FALSE;
}?>