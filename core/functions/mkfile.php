<? # $filename должен иметь относительный путь (типа dirname/filename.ext)
$log->LogInfo('Got this file');
function mkfile($filename, $mode = 0777, $contents) {
	global $log;
	$log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	$dir = preg_replace("/^(.*\/)[^\/]+$/", "\\1", $filename);
	if (!is_dir($dir)) { trigger_error("mkfile() failed, no such directory <strong>{$dir}</strong>, ", E_USER_WARNING); return(false); }
	if (file_exists($filename)) { trigger_error("mkfile() failed (File exists)", E_USER_WARNING); return(false); }
	if (is_array($contents)) $contents = implode("\n", $contents);
	if ($fp = fopen($filename, "w")) {
		if (is_null($contents)) {
			return($fp);
		} else {
			fwrite($fp, $contents);
			chmod($filename, $mode);
			fclose($fp);
			$log->LogDebug("File had been created");
			return TRUE;
		}
	} else {
		trigger_error("mkfile() failed (Wrong file permissions)", E_USER_WARNING);
		$log->LogDebug("File had NOT been created");
		return FALSE;
	}
}
?>