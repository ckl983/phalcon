<?php
/**
 *
 * @author --
 * @copyright 2014-2018
 */

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;

define('APP_NAME', 'app_mp');

define('IN_CLI', true);

define("ROOT_PATH", __DIR__);

$app_version = "v1.0";

/**
 * 环境
 * 可选值：production, develop, test
 */
define('ENVIRON', 'test');

define("APP_VERSION", $app_version);

define("DS", DIRECTORY_SEPARATOR);

define("APP_PATH", dirname(__DIR__) . DS);

define("BASE_PATH", dirname(dirname(APP_PATH)) . DS);

define("LIBRARY_PATH", BASE_PATH . "library" . DS);

define("DATA_PATH", BASE_PATH . "data" . DS);

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

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

$loader->registerNamespaces([
    'Phalcon' => LIBRARY_PATH . 'vendor/phalcon/incubator/Library/Phalcon/',
]);

$loader->registerDirs(array(
    __DIR__
), true);

$loader->register();

$di = new FactoryDefault();

Di::reset();

/**
 * Read services
 */
include APP_PATH . "config/services.php";

/**
 * Add any needed services to the DI here
 */
Di::setDefault($di);