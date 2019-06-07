<? # Очищает файл от комментов etc
$log->LogInfo('Got this file');
function clear_file ( $text = '', $br_lines = true) {
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	$text = preg_replace("/([a-z]+):\/\//", "\\1:/", $text); // заменяем ссылки 
	$text = preg_replace("/\/\/.*/", '', $text ); // удаляем однострочные комменты
	$text = preg_replace("/([a-z]+):\//", "\\1://", $text); // востанавливаем ссылки
	$text = preg_replace("/\/\*[\s\S]+?\*\//", '', $text ); // удаляем блочные комменты
	if($br_lines == true)
	$text = preg_replace("/\s/", ' ', $text); // удаляем переносы и т.д. - заменяем на пробелы	
	$text = preg_replace("/ {2,}/", ' ', $text ); // если пробелов больше 2-х , заменяем одним
	return $text;
}?>