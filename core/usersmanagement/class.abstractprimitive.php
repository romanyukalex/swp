<?
	class AbstractPrimitive {
		protected $_id = "";
		
		protected static $_values = array();
		
		//methods
		function __construct($id) {
			if (array_key_exists($id,static::$_values)) {
				$this->_id = $id;
			}
		}

		public function values() {
			return array_keys(static::$_values);
		}		
		
		public function display() {
			return static::$_values[$this->_id]["display"];
		}		
	};
?>