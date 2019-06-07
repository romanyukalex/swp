<? # Функции для кодирования емейлов

$log->LogInfo('Got this file');
function email_encode($email='info@domain.com', $linkText='Contact Us', $attrs ='class="emailencoder"' ){
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	// remplazar aroba y puntos
	$email = str_replace('@', '&#64;', $email);
	$email = str_replace('.', '&#46;', $email);
	$email = str_split($email, 5);

	$linkText = str_replace('@', '&#64;', $linkText);
	$linkText = str_replace('.', '&#46;', $linkText);
	$linkText = str_split($linkText, 5);
	
	$part1 = '<a href="ma';
	$part2 = 'ilto&#58;';
	$part3 = '" '. $attrs .' >';
	$part4 = '</a>';

	$encoded = '<script type="text/javascript">';
	$encoded .= "document.write('$part1');";
	$encoded .= "document.write('$part2');";
	foreach($email as $e){
		$encoded .= "document.write('$e');";
	}
	$encoded .= "document.write('$part3');";
	foreach($linkText as $l){
		$encoded .= "document.write('$l');";
	}
	$encoded .= "document.write('$part4');";
	$encoded .= '</script>';

	return $encoded;
}