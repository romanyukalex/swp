<? $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__)); 
if($_REQUEST['action']=="activate" and $nitka=="1"){
	$log->LogDebug(basename (__FILE__)."|".(__LINE__)." | Action is Activate. Trying to get activate.php ");
	include_once($_SERVER["DOCUMENT_ROOT"]."/modules/registration_form/activate.php");
} elseif ($_REQUEST['action']=="deactivate") {
	$log->LogDebug(basename (__FILE__)."|".(__LINE__)." | Action is Deactivate. Trying to get deactivate.php ");
	include_once($_SERVER["DOCUMENT_ROOT"]."/modules/registration_form/deactivate.php");
} else {$log->LogDebug(basename (__FILE__)."|".(__LINE__)." | Action is uncnown. Trying to insert registration_form module");
	insert_module("registration_form");
}?>