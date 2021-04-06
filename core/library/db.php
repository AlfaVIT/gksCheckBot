<?php
	namespace library;

	/**
	 * db
	 * 
	 * Класс для работы с БД SQLite3
	 * используется статически
	 */
	class db {
		private static $_db = null;
		private $_link;
		
		/**
		 * __construct
		 * 
		 * Подключаемся к БД
		 */
		private function __construct() {
			$this->_link = new \SQLite3(DB_NAME);
		}

		/**
		 * static function getDb
		 * 
		 * статическая функция для подключения к БД
		 * 
		 * @return SQLite3
		 */
		public static function getDb() {
			if ( is_null(self::$_db) ) {
				self::$_db = new self();
			}
			return self::$_db;
		}

		/**
		 * query
		 * 
		 * Выполняет SQL-запрос
		 * 
		 * @param string $sql
		 * @return SQLite3Result|Exception
		 */
		public function query($sql) {
//			return substr($sql, 0, 7);
			$exec = false;
			if ( substr($sql, 0, 6)=='SELECT' or 
				 substr($sql, 0, 6)=='INSERT' ) {
				$result = $this->_link->query($sql);
			} else {
				$result = $this->_link->exec($sql);
				$exec = true;
			}
			if ( !$result ) {
				throw new \Exception('dbError #'.$this->_link->lastErrorCode().' ['.$this->_link->lastErrorMsg().']');
			}
			if ( $exec ) { 
				return $result;
			} else {
				if ( substr($sql, 0, 6)=='SELECT' ) {
					$return = [];
					while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
						$return[] = $row;
					}	
				}
				if ( substr($sql, 0, 6)=='INSERT' ) {
					$result = $this->_link->query("SELECT last_insert_rowid()");
					$return = $result->fetchArray(SQLITE3_ASSOC);
					$return = $return['last_insert_rowid()'];
				}
				return $return;
			}
		}

		/**
		 * exec
		 * 
		 * Выполняет запрос без результата
		 * 
		 * @param string $sql
		 * @return boolean
		 */
		public function exec($sql) {
			$result = $this->_link->exec($sql);
			if ( !$result ) {
				throw new \Exception('dbError #'.$this->_link->lastErrorCode().' ['.$this->_link->lastErrorMsg().']');
			}
			return $result;
		}

		/**
		 * escape
		 * 
		 * Возвращает правильно экранированную строку
		 * 
		 * @param string $string
		 * @return string
		 */
		public function escape($string) {
			return $this->_link->escapeString($string);
		}

		/**
		 * md5
		 * 
		 * Возвращает захешированную md5 строку
		 * 
		 * @param string $string
		 * @return string
		 */
		public function hash($string) {
			return md5($string.DB_SULT);
		}

		public function randomString($length = 20) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}


	}
	

?>