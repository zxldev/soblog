<?php

error_reporting(E_ALL);
date_default_timezone_set('PRC');
use Phalcon\Mvc\Application;
use Phalcon\Config\Adapter\Ini as ConfigIni;

//$_GET['_url'] = '/contact/send';
//$_SERVER['REQUEST_METHOD'] = 'POST';

try {

	define('APP_PATH', realpath('..') . DIRECTORY_SEPARATOR);

	/**
	 * Read the configuration
	 */
    $config = include APP_PATH . "app/config/config.php";

	/**
	 * Auto-loader configuration
	 */
	require APP_PATH . 'app/config/loader.php';

	/**
	 * Load application services
	 */
	require APP_PATH . 'app/config/services.php';

    if(file_exists(APP_PATH . 'vendor/autoload.php')){
        require APP_PATH . 'vendor/autoload.php';
    }

	$application = new Application($di);

	echo $application->handle()->getContent();

} catch (Exception $e){
	echo $e->getMessage();
}
