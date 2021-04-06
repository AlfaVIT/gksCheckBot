<?php
	session_start();
 	require_once("core\config.php");

	if ( DISPLAY_ERRORS ) {
		ini_set('display_errors', 1);
	} else {
		ini_set('display_errors', 0);
	}

	use library\url;
	spl_autoload_register(function ($className) {
		$fileName = 'core/'.str_replace('\\', '/', $className).'.php';
		if ( !file_exists($fileName) ) {
			throw new Exception('Class not found on [ <strong>'.$fileName.'</strong> ]');
		}
		require_once($fileName);
	});

	$controllerName = ucfirst(url::getSegment(0)).ucfirst(url::getSegment(1));
	$controller = "controllers\controller".$controllerName;
	
	$actionName = url::getParam('action');
	$actionName = empty($actionName) ? "Index" : ucfirst($actionName);
	$action = "action".$actionName;

	try {
		if ( !file_exists('core\\'.$controller.'.php') ) {
			throw new library\httpException('Pege not found', '404');
		}
		$controller = new $controller();

		if ( !method_exists($controller, $action) ) {
			throw new library\httpException('Pege not found', '404');
		}
		$controller->$action();
	} catch ( library\httpException $e ) {
		header("HTTP/1.1 ".$e->getCode()." ".$e->getMessage());
		die($e->getMessage());
	} catch ( \Exception $e ) {
		die($e->getMessage());
	}


?>

