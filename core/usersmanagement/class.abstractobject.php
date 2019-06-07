<?
	class AbstractObject {
		protected $_id = 0;
		
		protected $_fieldsValue = array();
		
		protected static $_fields = array();

		//methods
		function __construct() {
			foreach (static::$_fields as $key=>$meta) {
				if (array_key_exists("default",$meta)) {
					$this->_fieldsValue[$key] = $meta["default"];
				}
				else {
					$this->_fieldsValue[$key] = "";
				}
			}
		}

		public function id() {
			return $_id;
		}
		
		public function fields() {
			return array_keys(static::$_fields);
		}
		
		public function fieldDisplay($fieldName) {
			if (array_key_exists($fieldName,static::$_fields)) {
				return static::$_fields[$fieldName]["display"];
			}
			else {
				return false;
			}
		}
		
		public function fieldValue($fieldName) {
			if (array_key_exists($fieldName,static::$_fields)) {
				return $this->_fieldsValue[$fieldName];
			}
			else {
				return false;
			}
		}
		
		public function get($id) {
			$this->_id = $id;
			return $this;
		}				
	};
?>