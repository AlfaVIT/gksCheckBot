<?php
	namespace library;

	class view {
		protected $_viewTemplateDir = __DIR__."/../views/template/";
		protected $_viewLayoutDir = __DIR__."/../views/layout/";
		protected $_title;
		protected $_seo = [];
		protected $_css = [];
		protected $_js = [];
		protected $_layout;
		protected $_template;

		public function __construct() {
			$layout = strtolower(url::getSegment(0));
			$template = strtolower(url::getParam('action'));
			$template = !empty($template) ? $template : strtolower(url::getSegment(1));
//			echo '$layout = '.$layout.'<br>';
//			echo '$template = '.$template.'<br>';
			$this->_title = ucfirst($template);
			$this->setLayout($layout);
			$this->setTemplate($template);
		}

		protected function resourceScan($folder, $extension='css') {
			$resources = glob(substr($folder, 0, strrpos($folder, '/')).'/'.$extension.'/*'.$extension);
			$resources = ( is_array($resources) ) ? $resources : array();
			return $resources;
		}

		protected function prepareResources($array = []) {
			$name_arr = [];
			foreach ( $array as $key=>$val ) {
				$valName = substr($val, strrpos($val, '/')+1);
				if ( in_array($valName, $name_arr) ) {
					unset($array[$key]);
				} else {
					$name_arr[] = $valName;
					$array[$key] = 'core/'.substr($val, strrpos($val, '../')+3);
				}
			}
			return $array;
		}

		public function render($tplName = null, $data = []) {
			if ( is_array($tplName) ) {
				$data = $tplName;
				$tplName = null;
			}
			if ( !empty($tplName) ) {
				$this->setTemplate($tplName);
			}

			if ( !file_exists($this->_layout) ) {
				throw new \Exception('Layout was not found! <strong>'.$this->_layout.'</strong>');
			}
			if ( !file_exists($this->_template) ) {
				throw new \Exception('Template was not found! <strong>'.$this->_template.'</strong>');
			}

			$layout_js = $this->resourceScan($this->_layout, 'js');
			$template_js = $this->resourceScan($this->_template, 'js');
			$js_resources = array_merge($layout_js, $template_js);
			$js_resources = $this->prepareResources($js_resources);
			foreach ( $js_resources as $js ) {
				$this->setJs($js);
			}
			$layout_css = $this->resourceScan($this->_layout, 'css');
			$template_css = $this->resourceScan($this->_template, 'css');
			$css_resources = array_merge($layout_css, $template_css);
			$css_resources = $this->prepareResources($css_resources);
			foreach ( $css_resources as $css ) {
				$this->setCss($css);
			}
			include $this->_layout;

		}

		public function setTitle($titleName) {
			$this->_title = $titleName;
		}

		public function getTitle() {
			return $this->_title;
		}

		public function setSeo($key, $val) {
			$this->_seo[$key] = $val;
		}

		public function getSeo($key) {
			return $this->_seo[$key];
		}

		public function setCss($css) {
			if ( !in_array($css, $this->_css) ) {
				$this->_css[] = $css;
			}
			rsort($this->_css);
		}

		public function getCss() {
			return $this->_css;
		}

		public function setJs($js) {
			if ( !in_array($js, $this->_js) ) {
				$this->_js[] = $js;
			}
			rsort($this->_js);
		}

		public function getJs() {
			return $this->_js;
		}

		public function setLayout($layout) {
			$this->_layout = $this->_viewLayoutDir.$layout.'/'.$layout.'.php';
		}

		public function setTemplate($template) {
			$this->_template = $this->_viewTemplateDir.$template.'/'.$template.'.php';
		}

	}
?>