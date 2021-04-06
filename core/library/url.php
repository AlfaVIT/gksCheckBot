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
		 * prepareSegments
		 * 
		 * Эта функция определяет имя контроллера и метода
		 * на основании строки запроса
		 * 
		 * @return array;
		 */
		protected static function prepareSegments() {
			$declaredControllers = glob('core/views/layout/*.php');
			$declaredControllers = is_array($declaredControllers) ? $declaredControllers : [];
			foreach ( $declaredControllers as $key=>$val ) {
				$declaredControllers[$key] = substr($val,18,-4);
			}
			
			$segments = ($_GET['url']);
			$segments = strtolower(preg_replace('/[^a-zA-Z\/]/m', '', $segments));
			$segments = explode('/', $segments);
			if ( empty($segments[count($segments)-1]) ) {
				unset($segments[count($segments)-1]);
			}

			// если передано не более одного элемента
			if ( is_null($segments[1]) ) {
				// если первый элемент является задекларированным
				if ( in_array($segments[0], $declaredControllers) ) {
					$segments[1] = 'Index';
				} else {
					$segments[1] = ( is_null($segments[0]) ) ? 'Index' : $segments[0];
					$segments[0] = 'Public';
				}
			}

			return $segments;
		}

		/**
		 * Статический метод getSegments
		 * 
		 * Возвращает массив сегментов адрессной 
		 * строки, разделённых символом "/"
		 * 
		 * @return array
		 */
		public static function getSegments() {
			$segments = self::prepareSegments();
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