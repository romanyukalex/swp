<? # Проверка валидности строки XML
	
function isValidXml($content){
	$content = trim($content);
	global $log;
	if (empty($content)) {
		$log->LogDebug("Content is not XML");
        return false;
    }
    //html go to hell!
    if (stripos($content, '<!DOCTYPE html>') !== false) {
		$log->LogDebug("Content is not XML");
		return false;
    }

    libxml_use_internal_errors(true);
    simplexml_load_string($content);
    $errors = libxml_get_errors();          
    libxml_clear_errors();  
	if(empty($errors)) {$log->LogDebug("Content is XML");
    return TRUE;
	} else {
		$log->LogDebug("Content is not XML");
		 return FALSE;
	}
}
/*
//false
var_dump(isValidXml('<!DOCTYPE html><html><body></body></html>'));
//true
var_dump(isValidXml('<?xml version="1.0" standalone="yes"?><root></root>'));
//false
var_dump(isValidXml(null));
//false
var_dump(isValidXml(1));
//false
var_dump(isValidXml(false));
//false
var_dump(isValidXml('asdasds'));
*/
?>
