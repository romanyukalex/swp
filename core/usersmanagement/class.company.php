<?
	require_once($_SERVER["DOCUMENT_ROOT"]."/adminpanel/pages/user_management/class.abstractobject.php");

	class Company extends AbstractObject {
		protected static $_fields = array(
			"form_of_business_ownership" => array("display"=>"����� �������������","db"=>"form_of_business_ownership"),
			"company_full_name" => array("display"=>"�������� ��������","db"=>"company_full_name"),
			"inn" => array("display"=>"���","db"=>"inn"),
			"kpp" => array("display"=>"���","db"=>"kpp"),
			"bik" => array("display"=>"���","db"=>"bik"),
			"country" => array("display"=>"������","db"=>"country_id","default"=>219),
			"city" => array("display"=>"�����","db"=>"city_id","default"=>17849),
			"legal_address" => array("display"=>"����������� �����","db"=>"legal_address"),
			"real_address" => array("display"=>"����������� �����","db"=>"real_address"),
			"post_address" => array("display"=>"�������� �����","db"=>"post_address"),
			"company_domain" => array("display"=>"����� ���-����� ��������","db"=>"company_domain"),
			"change_date" => array("display"=>"���� ���������� ��������� ������ � ��������","db"=>"change_date"),
			"creation_date" => array("display"=>"���� �������� ��������","db"=>"creation_date")
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