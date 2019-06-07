<?
	require_once($_SERVER["DOCUMENT_ROOT"]."/adminpanel/pages/user_management/class.abstractobject.php");

	class Company extends AbstractObject {
		protected static $_fields = array(
			"form_of_business_ownership" => array("display"=>"Форма собственности","db"=>"form_of_business_ownership"),
			"company_full_name" => array("display"=>"Название компании","db"=>"company_full_name"),
			"inn" => array("display"=>"ИНН","db"=>"inn"),
			"kpp" => array("display"=>"КПП","db"=>"kpp"),
			"bik" => array("display"=>"БИК","db"=>"bik"),
			"country" => array("display"=>"Страна","db"=>"country_id","default"=>219),
			"city" => array("display"=>"Город","db"=>"city_id","default"=>17849),
			"legal_address" => array("display"=>"Официальный адрес","db"=>"legal_address"),
			"real_address" => array("display"=>"Фактический адрес","db"=>"real_address"),
			"post_address" => array("display"=>"Почтовый адрес","db"=>"post_address"),
			"company_domain" => array("display"=>"Адрес веб-сайта компании","db"=>"company_domain"),
			"change_date" => array("display"=>"Дата последнего изменения данных о компании","db"=>"change_date"),
			"creation_date" => array("display"=>"Дата создания компании","db"=>"creation_date")
		);	
		
		//methods
		public function get($id) {
			$this->_id = $id;
			$query = mysql_query("SELECT * FROM `sc-companies` WHERE company_id = '$id'");
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