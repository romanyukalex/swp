<? 
# Не следует отправлять много писем в цикле, тк функция mail открывает и закрывает сессию с сервером под каждое письмо
$log->LogInfo('Got this file');
include_once($_SERVER['DOCUMENT_ROOT']."/core/system-param.php");
function sendletter($to_email_address,$subject,$message)
	{
	global $sitedomainname, $emailaddress, $from;
	sendletter_full($to_email_address,$to_email_address,$subject,$message,$from,$emailaddress);
	}
function sendletter_to_admin($subject,$message){
global $admin_email;
sendletter($admin_email,$subject,$message);
}
function sendletter_full($to_email_name,$to_email_address,$subject,$message,$from_email_name,$from_email_address,$cc=NULL,$importance=NULL){//,$attach_files=NULL){
	global $log,$sitedomainname;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	$separator = "---"; // разделитель в письме
	if(!$from_email_address or !$to_email_address) {
		 $log->LogError('No FROM or TO address: FROM - '.$from_email_address.' TO - '.$to_email_address);
	} else {
		//if($attach_files) $header .= "Content-Type: multipart/mixed; boundary=\"$separator\""; // в заголовке указываем разделитель
		//else{ 
			$header.="Content-type: text/html;  charset=\"UTF-8\"\r\n";
		//}
		
		$header.="From: =?utf-8?B?".base64_encode($from_email_name)."?= <".$from_email_address.">\r\n";
		if($cc) $header.="CC: =?utf-8?B?".base64_encode($from_email_name)."?= <".$from_email_address.">\r\n";
		$header.='Reply-To: noreply@'.$sitedomainname."\r\n";
		$header.="Content-Transfer-Encoding: utf-8\r\nContent-Disposition: inline\r\nMIME-Version: 1.0\r\n";
		if($importance=='high') {
			$header.= "X-Priority: 1 (Highest)\r\n";
			$header.= "X-MSMail-Priority: High\r\n";
		#	$headers .= "Importance: High\n";
		}
		//$message='<span class="actor vcard"><img class="photo attachment" align="absmiddle" src="https://psy-space.ru/project/freecon/files/freecon-favicon.png" /></span>'.$message;
		@ mail("=?utf-8?B?".base64_encode($to_email_name)."?= <".$to_email_address.">", '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);
	}
}?>