<?
	require_once($_SERVER["DOCUMENT_ROOT"]."/adminpanel/pages/user_management/class.abstractprimitive.php");	
	
	class Gender extends AbstractPrimitive {
		protected $_id = "male";
		
		protected static $_values = array(
			"male" => array("display"=>"Мужчина"),
			"female" => array("display"=>"Женщина")
		);
	};
?>