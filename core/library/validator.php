<?php
	namespace library;

	class validator {

		public $_errors = [];
		protected $_rules = [];
		protected $_data = [];
		protected $_db;

		public function __construct() {
			$this->_db = db::getDb();
		}

		protected function min($field, $param) {
			if ( strlen($this->_data[$field])<(int)$param ) {
				$this->addError($field, 'Поле '.$field.' не может быть короче '.$param.' символа(ов)!');
			}
		}

		protected function spec($field, $param) {
			$spec_len = preg_match_all('/[^\w]/m', $this->_data[$field], $matches, PREG_SET_ORDER, 0);
			if ( $spec_len<(int)$param ) {
				$this->addError($field, 'Поле '.$field.' должно содержать как минимум '.$param.' спецсимвола(ов)!');
			}
		}

		protected function required($field, $param) {
			if ( empty($this->_data[$field]) ) {
				$this->addError($field, 'Поле '.$field.' не может быть пустым!');
			}
		}

		protected function email($field, $param) {
			if ( !preg_match('/^([\w\-.])+@+([\w\-]{2}+.+[a-zA-Z]{2})$/', $this->_data[$field]) ) {
				$this->addError($field, 'Не корректный формат поля e-mail!');
			}
		}

		public function addError($field, $error) {
			$this->_errors[$field] = $error;
		}

		public function getErrors() {
			return $this->_errors;
		}

		public function getError($field) {
			return $this->_errors[$field];
		}

		public function validate($data, $rules) {
			$this->_data = $data;
			$this->_rules = $rules;

			foreach ( $this->_rules as $field=>$rules ) {
				foreach ( $rules as $rule ) {
					$rule_param = false;
					if ( strpos($rule, '::') ) {
						$rule_param = substr($rule, strpos($rule, '::')+2);
						$rule = substr($rule, 0, strpos($rule, '::'));
					}
			 		if ( method_exists($this, $rule) ) {
			 			if ( is_null($this->getError($field)) ) {
		 					$this->$rule($field, $rule_param);
			 			}
			 		} else {
			 			throw new \Exception("Не описанное правило валидации <strong>[ ".$rule."(".$rule_param.") ]</strong>");
			 		}
				}
			}

			if ( !empty($this->_errors) ) {
				return false;
			}
			return true;
		}

	}
?>