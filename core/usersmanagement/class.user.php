<?
	@include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	require_once($_SERVER["DOCUMENT_ROOT"]."/adminpanel/pages/user_management/class.abstractobject.php");
	
	require_once($_SERVER["DOCUMENT_ROOT"]."/adminpanel/pages/user_management/class.userrole.php");
	require_once($_SERVER["DOCUMENT_ROOT"]."/adminpanel/pages/user_management/class.gender.php");
	require_once($_SERVER["DOCUMENT_ROOT"]."/adminpanel/pages/user_management/class.company.php");
	require_once($_SERVER["DOCUMENT_ROOT"]."/adminpanel/pages/user_management/class.country.php");

	class User extends AbstractObject{
		protected static $_fields = array(
			"login" => array("display"=>"Логин","db"=>"login"),
			"password" => array("display"=>"Пароль","db"=>"password"),
			"user_role" => array("display"=>"Роль на сайте","db"=>"userrole","default"=>"unknown"),
			"full_name" => array("display"=>"Полное имя","db"=>"fullname"),
			"gender" => array("display"=>"Пол","db"=>"gender","default"=>"male"),
			"birthdate" => array("display"=>"Дата рождения","db"=>"birthdate"),
			"company" => array("display"=>"Компания","db"=>"company_id"),
			"contact_mail" => array("display"=>"Контактная почта","db"=>"contactmail"),
			"contact_phone" => array("display"=>"Контактный телефон","db"=>"contact_phone"),
			"country" => array("display"=>"Страна","db"=>"country_id","default"=>219),
			"city" => array("display"=>"Город","db"=>"city_id","default"=>17849),
			"region" => array("display"=>"Регион","db"=>"region_id","default"=>1611),
			"address" => array("display"=>"Адрес","db"=>"address"),
			"status" => array("display"=>"Статус","db"=>"status"),
			"created_at" => array("display"=>"Создан","db"=>"timestamp")
		);	
		
		private static $_fieldsGroups = array(
			"access"  => array("display"=>"Доступ","members"=>array("login","password","user_role")),
			"person"  => array("display"=>"Личные данные","members"=>array("full_name","gender","birthdate")),
			"contact" => array("display"=>"Контактные данные","members"=>array("company","contact_mail","contact_phone","country","region","city","address")),
			"system"  => array("display"=>"Системные данные","members"=>array("status","created_at"))
		);
		
		private static $_fieldsGroupsOrder = array("system","access","person","contact");	

		//methods
		public function get($id) {
			$this->_id = $id;
			$query = mysql_query("SELECT * FROM `tscloud-users` WHERE userid = '$id'");
			if ($data = mysql_fetch_array($query)) {
				foreach (self::$_fields as $key=>$meta) {
					if ($data[$meta["db"]] != "") {
						$this->_fieldsValue[$key] = $data[$meta["db"]];
					}
				}
			}	
			return $this;
		}		
	};
?>