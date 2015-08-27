<?php

return new \Phalcon\Config(
    array(
        'database' => array(
            'adapter' => 'Mysql',
            'host' => '',
            'username' => 'root',
            'password' => '',
            'dbname' => '',
            'charset' => 'utf8', //数据库字符集 utf8
        ),
        'server' => array(
            'redis' => array(
                'ip' => '',
                'port' => '6379',
                'auth' => ''
            ),
        ),
        'application' => array(
            'modelsDir' => APP_PATH.'app/models/', //用于指示代码生成器models目录在哪里
            'controllersDir' => APP_PATH.'app/controllers/',//用于指示代码生成器controllersDir目录在哪里
            'viewsDir' => APP_PATH.'app/views/',//用于指示代码生成器controllersDir目录在哪里
            'cacheDir' => APP_PATH.'app/cache/',
            'pluginsDir' => APP_PATH.'app/plugins/',
            'formsDir' => APP_PATH.'app/forms/',
            'libraryDir' => APP_PATH.'app/library/',
            'baseUri' => '/',
            'cryptKey' => '#ldjB$=dp?.ak//j1V$a!d#d',// 只支持16, 24 或 32位
            //是否debug模式
            'debug' => true,
            //高级调试模式开关。
            'SeniorDebug' => true,
            'registerDir'=>array(
                'default' => array(
                    'modelsDir' => APP_PATH.'app/models/', //用于指示代码生成器models目录在哪里
                    'controllersDir' => APP_PATH.'app/controllers/',//用于指示代码生成器controllersDir目录在哪里
                    'viewsDir' => APP_PATH.'app/views/',//用于指示代码生成器controllersDir目录在哪里
                    'pluginsDir' => APP_PATH.'app/plugins/',
                    'formsDir' => APP_PATH.'app/forms/',
                    'libraryDir' => APP_PATH.'app/library/',
                    'libraryDirResponse' => APP_PATH.'app/library/responses',
                )
            ),
            'namespaecs'=>array(
            ),
        ),
        'blog'=>array(
            'author'=>''
        ),
        'github'      => array(
            'clientId'     => '',
            'clientSecret' => '',
            'redirectUri'  => ''
        ),
    ));