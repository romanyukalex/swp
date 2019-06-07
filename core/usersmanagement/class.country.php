<?
	require_once($_SERVER["DOCUMENT_ROOT"]."/adminpanel/pages/user_management/class.abstractobject.php");	
	
	class Country extends AbstractObject {
		protected static $_fields = array(
			"oid" => array("display"=>"OID","db"=>"oid"),
			"country_name_ru" => array("display"=>"Название страны","db"=>"country_name_ru"),
			"country_name_en" => array("display"=>"Country name","db"=>"country_name_en")
		);			
		
		//methods
		
		public function get($id) {
			$this->_id = $id;
			$query = mysql_query("SELECT * FROM `tscloud-country` WHERE id = '$id'");
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