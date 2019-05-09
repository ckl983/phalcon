<?php
/**
 * @desc 自动加载配置文件
 *
 * @author --
 * @copyright 2014-2018
 */

$loader = new \Phalcon\Loader();

/**
 * 注册自动加载目录
 */
$loader->registerDirs(
    array(
        // 应用
        APP_PATH . "controllers/",
        APP_PATH . "tasks/",
        APP_PATH . "models/",
        APP_PATH . "logics/",
        APP_PATH . "includes/",
        APP_PATH . "plugins/",
        APP_PATH . "vendor/",

        // 全局
        LIBRARY_PATH . "controllers/",
        LIBRARY_PATH . "models/",
        LIBRARY_PATH . "includes/",
        LIBRARY_PATH . "plugins/",
        LIBRARY_PATH . "vendor/",
    )
);

$loader->register();
