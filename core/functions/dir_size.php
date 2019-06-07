<? # Размер директории
$log->LogInfo('Got this file');

function dirsize($size) {
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	$kor = $_SERVER['DOCUMENT_ROOT'];
	$kor = preg_replace('/[A-Z]\:/','',$kor);
	$size = disk_free_space($kor.$size);
	if ($size >= 1073741824) {
	$size = round($size / 1073741824 * 100) / 100 . 'Gb';
	} elseif ($size >= 1048576) {
	$size = round($size / 1048576 * 100) / 100 . 'Mb';
	} elseif ($size >= 1024) {
	$size = round($size / 1024 * 100) / 100 . ' Kb';
	} else {
	$size = $size . ' b';
	}
	return $size;
}

//echo dirsize('/');?>