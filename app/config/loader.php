<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
//构造注册目录
$dirs = array();
$namespace = array();
foreach($config->application->registerDir as $item ){
    foreach($item as $key => $value){
        $dirs[] = $value;
    }
}

foreach($config->application->namespaecs as $key => $value ){
    $namespace[$key] = $value;
}
$loader->registerNamespaces($namespace);
$loader->registerDirs($dirs)->register();

