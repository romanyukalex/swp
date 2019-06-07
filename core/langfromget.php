<? # Определяет какой язык запрашивает пользователь
$log->LogInfo('Got this file');
$language=process_data($_REQUEST['lang'],2);
if ($language and ($language=="ru" or $language=="en")) {
	$lang_in="REQUEST";
	$_SESSION['language']=$language;
	}
elseif ((!$language or empty($language) or $language='') and $_SESSION['language'] and ($_SESSION['language']=="ru" or $_SESSION['language']=="en")) {
	$lang_in="SESSION";
	$language=$_SESSION['language'];
	}
elseif ((!$language or empty($language) or $language='') and !$_SESSION['language']) {
	//$log->LogDebug('Use default language');
	$lang_in="DB (default)";
	$language=$_SESSION['language']=$default_language;
	}
	
if($language) $log->LogInfo('Got language from '.$lang_in.'.Language is '.$language);
else $log->LogError('We cant get language. SESSION is '.$_SESSION['language'].', REQUEST is '.var_dump($language));
unset($lang_in);
?>