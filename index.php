<?php
	use library\url;
	spl_autoload_register(function ($className) {
		$fileName = 'core/'.str_replace('\\', '/', $className).'.php';
		require_once($fileName);
	});


	$controllerName = url::getSegment(0);
	$controllerName = ( is_null($controllerName) ) ? 'Main' : ucfirst($controllerName);
	$controller = "controllers\controller".$controllerName;
	
	$actionName = url::getSegment(1);
	$actionName = ( is_null($actionName) ) ? 'Index' : ucfirst($actionName);
	$action = "action".$actionName;

//	echo '$controller = '.$controller."<br>";
//	echo '$action = '.$action."<br>";
	try {
		if ( !file_exists('core\\'.$controller.'.php') ) {
			throw new Exception('Not found', '404');
		}
		$controller = new $controller();

		if ( !method_exists($controller, $action) ) {
			throw new Exception('Not found', '404');
		}
		$controller->$action();
	} catch ( Exception $e ) {
		header("HTTP/2.0 ".$e->getCode()." ".$e->getMessage());
		die($e->getMessage());
	}


?>