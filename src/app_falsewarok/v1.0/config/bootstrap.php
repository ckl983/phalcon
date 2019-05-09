<?php
/**
 *
 * @author --
 * @copyright 2014-2018
 */

// 应用名称
define('APP_NAME', 'app_mp');
/**
 * 环境
 * 可选值：production, develop, test
 */
if (isset($_SERVER['ENVIRON'])) {
    define('ENVIRON', $_SERVER['ENVIRON']);
}

define("DS", DIRECTORY_SEPARATOR);

define("APP_PATH", dirname(__DIR__) . DS);

define("BASE_PATH", dirname(dirname(APP_PATH)) . DS);

define("LIBRARY_PATH", BASE_PATH . "library" . DS);

define("DATA_PATH", BASE_PATH . "data" . DS);

/**
 * Application Vendor Autoload
 */
include APP_PATH . 'vendor/autoload.php';

/**
 * Library Vendor Autoload
 */
include LIBRARY_PATH . 'vendor/autoload.php';

/**
 * Read the configuration
 */
$config = include APP_PATH . "config/config.php";

/**
 * 自动加载
 */
include APP_PATH . "config/loader.php";

/**
 * Read services
 */
$di = include APP_PATH . "config/services.php";

/**
 * Handle the request
 */
$application = new \WPLib\Mvc\Application($di);

$di->set('application', $application, true);
