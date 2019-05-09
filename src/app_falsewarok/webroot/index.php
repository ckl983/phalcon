<?php
/**
 * @desc 入口文件
 *
 * @author --
 * @copyright 2014-2018
 */

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

date_default_timezone_set('Asia/Shanghai');

// $debug = new \Phalcon\Debug();
// $debug->listen();

try {
    // 应用名称
    define('APP_NAME', 'app_falsework');
    /**
     * 环境
     * 可选值：production, develop, test
     */
    if (isset($_SERVER['ENVIRON'])) {
        define('ENVIRON', $_SERVER['ENVIRON']);
    }

    /**
     * banben
     */
    $app_version = "v1.0";
    if (preg_match('/^\/(v[\d\.]+)(.+)$/', $_SERVER['REQUEST_URI'], $res)) {
        $app_version            = $res[1];
        $_SERVER['REQUEST_URI'] = $res[2];
    }

    define("APP_VERSION", $app_version);

    define("DS", DIRECTORY_SEPARATOR);

    define("APP_PATH", dirname(__DIR__) . DS . APP_VERSION . DS);

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
    include APP_PATH . "config/services.php";

    /**
     * Handle the request
     */
    $application = new \WPLib\Mvc\Application($di);

    $di->set('application', $application, true);

    echo $application->handle($_SERVER['REQUEST_URI'])->getContent();

} catch (\Exception $e) {
    /**
     * @todo 错误捕获处理
     */
    Logger::begin();
    Logger::info(sprintf("\nCLIENT IP:%s\nURL:%s\nRAW:%s\nPOST:%s\nGET:%s\nSERVER: %s",
        Helper::getClientIp(),
        $_SERVER['QUERY_STRING'],
        file_get_contents('php://input'),
        http_build_query($_POST),
        http_build_query($_GET),
        json_encode($_SERVER)
    ));

    Logger::error(sprintf("%s[%s]: %s", $e->getFile(), $e->getLine(), $e->getMessage()));
    Logger::error($e->getTraceAsString());
    Logger::commit();
    if (defined('IS_CHANGE_HTTP_STATUS') && IS_CHANGE_HTTP_STATUS == true) {
        header("HTTP/1.1 500 Internal Server Error");
    }
    echo json_encode([
        'status' => 500,
        'info'   => '服务器繁忙！',
        'data'   => [],
    ]);
}
