<? # Ищет строку в файле
// if(file_search_in($_REQUEST['someid1'].".torrent",'<h1 class="pagetitle">')){ echo "found";	}
$log->LogInfo('Got this file');
function file_search_in ( $file, $search_string ) {
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	$line_number = false;

	if ($handle = fopen($file, "r")) {
	$count = 0;
	while (($line = fgets($handle, 4096)) !== FALSE and !$line_number) {
		$count++;
		if(mb_strpos($line,  $search_string) !== FALSE) $line_number=$count;
	}
	fclose($handle);
	}

	return $line_number;
	
}?>