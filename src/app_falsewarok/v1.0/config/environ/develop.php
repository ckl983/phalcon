<?php
/**
 * @desc 开发环境配置文件
 *
 * @author --
 * @copyright 2014-2018
 */

return [
    'application' => [
        'showErrors'     => true,
        'baseUri'        => '/',
    ],
    'database' => [
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'port'        => '3306',
    ],
    'cache' => [
        'redis' => [
            "servers" => [
                [
                    'host'   => '127.0.0.1',
                    'port'   => 6379,
                    'auth' => '',
                ],
            ],
            'prefix' => 'dashboard::',
        ],
    ]
];
