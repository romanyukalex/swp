<?   
$log->LogInfo('Got this file');
function mkDirE($dir,$dirmode=700) {
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	if (!empty($dir)){
	   if (!file_exists($dir)){
		   preg_match_all('/([^\/]*)\/?/i', $dir,$atmp);
		   $base="";
		   foreach ($atmp[0] as $key=>$val) {
			   $base=$base.$val;
				if(!file_exists($base))
					if (!mkdir($base,$dirmode)){
						$log->LogError("Error: Cannot create ".$base);
						return -1;
					}
			}
	   }
	   else
			if (!is_dir($dir)){
				$log->LogError("Error: ".$dir." exists and is not a directory");
				return -2;
			}
	}

	return 0;
} ?>