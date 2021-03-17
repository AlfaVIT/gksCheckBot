<?php
	namespace library;

	/**
	 * Class Url
	 * 
	 * Класс для работы со строкой запроса
	 * 
	 * @package library
	 */
	class url {
		/**
		 * Статический метод getSegments
		 * 
		 * Возвращает массив сегментов адрессной 
		 * строки, разделённых символом "/"
		 * 
		 * @return array
		 */
		public static function getSegments() {
			$segments = explode('/', $_GET['url']);
			if ( empty($segments[count($segments)-1]) ) {
				unset($segments[count($segments)-1]);
			}
			return $segments;
		}

		/**
		 * Статический метод getSegment
		 * 
		 * Возвращает сегмент из адресной строки по 
		 * его номеру, начиная с 0
		 * 
		 * @param integer $n
		 * @return string|null
		 */
		public static function getSegment($n) {
			$segments = self::getSegments();
			return $segments[$n];
		}

		/**
		 * Статический метод getParam
		 * 
		 * Возвращает значение параметра из массива
		 * $_GET по его имени
		 * 
		 * @param string $paramName
		 * @return string|null
		 */
		public static function getParam($paramName) {
			return urlencode($_GET[$paramName]);
		}

		/**
		 * Статический метод getUrlString
		 * 
		 * Возвращает строку запроса $_SERVER['REQUEST_URI']
		 * 
		 * @return string
		 */
		public static function getUrlString() {
			return $_SERVER['REQUEST_URI'];
		}
	}

?>