<? 
if(!$_REQUEST['action']) insert_module("registration_form","show_registration_form");
else {
	$action=process_data($_REQUEST['action'],30);
	insert_module("registration_form","$action");
}