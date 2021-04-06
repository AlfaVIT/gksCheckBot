<?php
	namespace base;
	use library\db;
	use library\user;

	/**
	 * baseModel
	 * 
	 * Базовый класс контроллеров, в котором
	 * подключаются необходимые ресурсы
	 */
	class baseModel {

		protected $_db;
		protected $_user;

		/**
		 * __construct
		 * 
		 * инициирует базовые переменные
		 */
		public function __construct() {
			$this->_db = db::getDb();
			$this->_user = new user();
		}



	}
?>