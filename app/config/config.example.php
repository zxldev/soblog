<?php
defined('APP_PATH') or define('APP_PATH', realpath('../..') . DIRECTORY_SEPARATOR);

return new \Phalcon\Config(
    array(
        'site'        => array(
            'url' => '',
        ),
        'database'    => array(
            'adapter'  => 'Mysql',
            'host'     => '',
            'username' => 'root',
            'password' => '',
            'dbname'   => '',
            'charset'  => 'utf8', //数据库字符集 utf8
        ),
        'server'      => array(
            'redis'  => array(
                'ip'      => '',
                'port'    => '6379',
                'auth'    => '',
                'dbindex' => '',
            ),
            'sphinx' => array(
                'ip'   => '',
                'port' => '',
            ),
        ),
        'application' => array(
            'modelsDir'      => APP_PATH.'app/models/', //用于指示代码生成器models目录在哪里
            'controllersDir' => APP_PATH.'app/controllers/',//用于指示代码生成器controllersDir目录在哪里
            'viewsDir'       => APP_PATH.'app/views/',//用于指示代码生成器controllersDir目录在哪里
            'cacheDir'       => APP_PATH.'app/cache/',
            'pluginsDir'     => APP_PATH.'app/plugins/',
            'formsDir'       => APP_PATH.'app/forms/',
            'libraryDir'     => APP_PATH.'app/library/',
            'baseUri'        => '/',
            'cryptKey'       => '#ldjB$=dp?.ak//j1V$a!d#d',// 只支持16, 24 或 32位
            //是否debug模式
            'debug'          => false,
            //高级调试模式开关。
            'SeniorDebug'    => false,
            'registerDir'    => array(
                'default' => array(
                    'modelsDir'      => APP_PATH.'app/models/', //用于指示代码生成器models目录在哪里
                    'controllersDir' => APP_PATH.'app/controllers/',//用于指示代码生成器controllersDir目录在哪里
                    'viewsDir'       => APP_PATH.'app/views/',//用于指示代码生成器controllersDir目录在哪里
                    'pluginsDir'     => APP_PATH.'app/plugins/',
                    'formsDir'       => APP_PATH.'app/forms/',
                ),
            ),
            'namespaecs'     => array(
                'Souii'             => APP_PATH.'app/library/',
                'Souii\Models'      => APP_PATH.'app/models/',
                'Souii\Controllers' => APP_PATH.'app/controllers/',
            ),
        ),
        'blog'        => array(
            'author' => '',
        ),
        'thirdpart'   => array(
            'weibo'      => array(
                "WB_AKEY"         => '',
                "WB_SKEY"         => '',
                "WB_CALLBACK_URL" => 'http:///session/weibologincallback',
            ),
            'weibosite'  => array(
                "WB_AKEY"         => '',
                "WB_SKEY"         => '',
                "WB_CALLBACK_URL" => 'http:///session/weibologincallback',
            ),
            'github'     => array(
                'clientId'     => '',
                'clientSecret' => '',
                'redirectUri'  => 'http://www./session/githubaccesstoken/',
            ),
            'qiniu'      => array(
                'accessKey' => '',
                'secretKey' => '',
                'bucket'    => '',
            ),
            'weixinqiye' => array(
                'token'          => '',
                'encodingAesKey' => '',
                'corpId'         => '',
            ),
        ),

    ));