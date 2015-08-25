<?php

use Phalcon\Mvc\View;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaData;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * We register the events manager
 */
$di->set('dispatcher', function() use ($di,$config) {

    $eventsManager = $di->getShared('eventsManager');

    //调试模式下不拦截， 展示错误。
    if(!$config->application->debug){
        /**
         * Handle exceptions and not-found exceptions using NotFoundPlugin
         */
        $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);
    }

    /**
     * Check if the user is allowed to access certain action using the SecurityPlugin
     */
    $eventsManager->attach('dispatch:beforeDispatch', new SecurityPlugin);


    $dispatcher = new Phalcon\Mvc\Dispatcher();

    //-----------------------WARNING！----------------------------
    //-------------------------注意！-----------------------------
    //高级调试模式时，会允许访问所有链接【如果不是非常明白，严禁打开此模式，严禁注释此代码！】
    if(!$config->application->SeniorDebug){
        $dispatcher->setEventsManager($eventsManager);
    }
    return $dispatcher;
});


/**
 * The URL component is used to generatef all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($config->application->baseUri);
    return $url;
}, true);


$di->set('view', function() use ($config) {

    $view = new View();

    $view->setViewsDir( $config->application->viewsDir);

    $view->registerEngines(array(
        ".volt" => 'volt'
    ));

    return $view;
});


require APP_PATH . 'app/config/Volt.php';

/**
 * 注解路由
 */
$di->set('router', function() use ($config){
    $router = new \Phalcon\Mvc\Router\Annotations(true);
    $router->addResource('Api');
    $router->addResource('Index');
    $router->addResource('Article');
//    $router->addResource('MFront');
    return $router;
});


/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db',function () use ($config,$di) {

        $connection = new DbAdapter($config->database->toArray());

        $debug = $config->application->debug;
        if ($debug) {
            $eventsManager = $di->getShared('eventsManager');

            $logger = $di->getShared('logger');

            //Listen all the database events
            $eventsManager->attach(
                'db',
                function ($event, $connection) use ($logger) {
                    /** @var Phalcon\Events\Event $event */
                    if ($event->getType() == 'beforeQuery') {
                        /** @var DatabaseConnection $connection */
                        $variables = $connection->getSQLVariables();
                        if ($variables) {
                            $logger->log($connection->getSQLStatement() . ' [' . join(',', $variables) . ']', \Phalcon\Logger::INFO);
                        } else {
                            $logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
                        }
                    }
                }
            );

            //Assign the eventsManager to the db adapter instance
            $connection->setEventsManager($eventsManager);
        }
        return $connection;
    }
);




/**
 * write the logger
 */
$di->setShared('logger',function(){
    $data = date('Y-m-d');
    return   new Phalcon\Logger\Adapter\File(APP_PATH."/app/logs/debug$data.log");
});



/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function ()  use ($config) {
    $reids = $config->server['redis'];
    $array = array(
        'path' => "http://".$reids['ip'].":".$reids['port']."?auth=".$reids['auth']."",
//        'name'=>'',
//        'lifetime'=>'',
//        'cookie_lifetime'=>'',
//        'cookie_secure'=>'',
//        'cookie_domain' =>'bst.com',
    );
    $session = new RedisSession($array);
    $session->start();
    return $session;
});


$di->setShared('redis',function()  use ($config){
    $reids = $config->server['redis'];
    $redis = new Redis();
    $redis->connect($reids['ip'],$reids['port']);
    $redis->auth($reids['auth']);
    return $redis;
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function() {
    return new MetaData();
});

/**
 * Start the session the first time some component request the session service
 */
//$di->set('session', function() {
//	$session = new SessionAdapter();
//	$session->start();
//	return $session;
//});

/**
 * Register the flash service with custom CSS classes
 */
$di->set('flash', function(){
    return new FlashSession(array(
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
    ));
});

/**
 * Register a user component
 */
$di->set('elements', function(){
    return new Elements();
});


$di->set('config', $config);

/**
 * 注解
 */
$di->setShared('annotations', function () {
    $reader = new Phalcon\Annotations\Adapter\Xcache();
    return $reader;
});