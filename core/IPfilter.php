<? 
$log->LogInfo('Got this file');
include_once($_SERVER['DOCUMENT_ROOT'].'/core/IPreal.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/core/functions/IPinRange.php');
if(ipinrange ($valid_ip_address,$ip)==false){$block=1;}
?>