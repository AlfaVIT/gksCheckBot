<?php
	namespace base;
	use library\db;
	use library\user;
	use library\view;
	use library\validator;

	/**
	 * baseController
	 * 
	 * Базовый класс контроллеров, в котором
	 * подключаются необходимые ресурсы
	 */
	class baseController {

		protected $_db;
		protected $_user;
		protected $_view;
		protected $_validator;
		protected $_errors;

		/**
		 * __construct
		 * 
		 * инициирует базовые переменные
		 */
		public function __construct() {
			$this->_db = db::getDb();
			$this->_user = new user();
			$this->_view = new view();
			$this->_validator = new validator();
		}

		public function loadModel($modelName, $data=null) {
			$model = 'models\\'.$modelName;
			$model = new $model($data);
			return $model;
		}

		public function validate($data, $rules) {
			$this->_validator->setData($data);
			$this->_validator->setRules($rules);
			if ( !$this->_validator->validate() ) {
				$this->_errors = $this->_validator->getErrors();
				return false;
			}
			return true;
		}

		public function trim($string) {
			return trim($string);
		}

		public function escape($string) {
			return $this->_db->escape($string);
		}

		public function hash($string) {
			return $this->_db->hash($string);
		}



	}
?>