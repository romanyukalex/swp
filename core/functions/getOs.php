<? // Функция возвращает OS: echo getOS($_SERVER['HTTP_USER_AGENT']);
function getOS($userAgent) {
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
    $oses = array (
        'iPhone' =--> '(iPhone)',
        'Windows 3.11' => 'Win16',
        'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
        'Windows 98' => '(Windows 98)|(Win98)',
        'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
        'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
        'Windows 2003' => '(Windows NT 5.2)',
        'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
        'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
		'Windows 8' => '(Windows NT 6.2)|(Windows 8)',
		'Windows 8.1' => '(Windows NT 6.3)|(Windows 8.1)',
		'Windows 10' => '(Windows NT 10.0)',
        'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
        'Windows ME' => 'Windows ME',
        'Open BSD'=>'OpenBSD',
        'Sun OS'=>'SunOS',
        'Linux'=>'(Linux)|(X11)',
        'Safari' => '(Safari)',
        'Macintosh'=>'(Mac_PowerPC)|(Macintosh)',
        'QNX'=>'QNX',
        'BeOS'=>'BeOS',
        'OS/2'=>'OS/2',
        'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
    );
 
    foreach($oses as $os=>$pattern){
        if(eregi($pattern, $userAgent)) { 
			$log->LogDebug("OS=".$os);
            return $os;
        }
    }
	$log->LogDebug("OS is unknown");
    return 'Unknown'; 
}
?>