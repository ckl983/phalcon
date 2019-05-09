<?php
/**
 * @desc 配置主文件
 *
 * @author --
 * @copyright 2014-2018
 */

!defined('APP_NAME') && define('APP_NAME', 'app_falsework');

!defined('APP_VERSION') && define('APP_VERSION', 'v1.0');

!defined('DS') && define("DS", DIRECTORY_SEPARATOR);

!defined("APP_PATH") && define("APP_PATH", dirname(__DIR__) . DS);

!defined("BASE_PATH") && define("BASE_PATH", dirname(dirname(APP_PATH)) . DS);

!defined("LIBRARY_PATH") && define("LIBRARY_PATH", BASE_PATH . "library" . DS);

!defined("DATA_PATH") && define("DATA_PATH", BASE_PATH . "data" . DS);

!defined('ENVIRON') && define('ENVIRON', 'production');

!defined('DEBUG_LEVEL') && define('DEBUG_LEVEL', 0);

!defined('IN_CLI') && define('IN_CLI', false);

return new Phalcon\Config(
    array_replace_recursive(
        include LIBRARY_PATH . "/config/common.php",
        [
            'application' => [
                'app_id'           => 10000,
                'app_name'         => '鹰眼',
                'secret'           => 'ZkaYLrDsXEDeO7qHv7imJCWAprCy0u7K',
                'showErrors'       => false,
                'baseUri'          => '/',
            ],
            'database' => [
                "adapter"     => "Mysql",
                "dbname"      => "",
                "charset"     => "utf8",
		        "port"	      => "3306",
            ],
            'cache' => [
                'frontend' => [
                    'lifetime'    => 3600,
                ],
                'backend' => [
                    'client'       => [],
                    'prefix' => 'xxx::fw::falsework::backend::',
                    'lifetime' => 3600,
                ],
                'metadata' => [
                    'client' => [],
                    'prefix' => 'xxx::fw::falsework::metadata::',
                    'lifetime' => 86400,
                    // 'persistent' => false,
                ],
                'redis' => [
                    'servers' => [],
                    'prefix' => 'xxx::fw::falsework::',
                    'statsKey' => '',
                ],
            ],
            'mq' => [
                'adapter' => 'Redis',
                'prefix'  => 'xxx::fw::falsework::mq::',
                'statsKey' => '',
            ],
            'logger' => [
                'filename' => sprintf('%slogs/%s_%s/application%s.log', DATA_PATH, APP_NAME, APP_VERSION, IN_CLI ? '_console' : ''),
            ],
            'view' => [
                // 'layoutDir'        => BASE_PATH . 'views/common/',
                'themeDir'         => APP_PATH . 'views/',
                'mainView'         => 'index',
                'appName'          => APP_NAME,
                'cacheTime'        => 7200,
                'cacheDir'         => DATA_PATH . 'cache/' . APP_NAME . '/',
                'compiledDir'       => DATA_PATH . 'compiled/' . APP_NAME . '/',
                'defaultThemesDir' => 'default',
                'compileAlways'    => false,
            ],
        ],
        include __DIR__ . "/environ/" . ENVIRON . ".php"
    )
);
