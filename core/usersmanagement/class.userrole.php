<?
	require_once($_SERVER["DOCUMENT_ROOT"]."/adminpanel/pages/user_management/class.abstractprimitive.php");	
	
	class UserRole extends AbstractPrimitive {
		protected $_id = "unknown";
		
		protected static $_values = array(
			"superuser" => array("display"=>"Суперпользователь"),
			"user" => array("display"=>"Пользователь"),
			"unknown" => array("display"=>"Неизвестно")
		);
	};
?>