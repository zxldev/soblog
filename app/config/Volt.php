<?php
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
/**
 * Created by PhpStorm.
 * User: zx
 * Date: 2015/8/24
 * Time: 12:34
 */


/**
 * Setting up volt
 */
$di->set('volt', function($view, $di) {

    $volt = new VoltEngine($view, $di);

    $volt->setOptions(array(
        "compiledPath" => APP_PATH . "cache/volt/"
    ));

    /**
     * Load application services
     */


    $compiler = $volt->getCompiler();
//    $compiler->addFunction('substr', 'substr');

    return $volt;
}, true);