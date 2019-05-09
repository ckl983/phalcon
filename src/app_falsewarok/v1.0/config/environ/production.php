<?php
/**
 * @desc 生产环境配置文件
 *
 * @author --
 * @copyright 2014-2018
 */
return [
    'application' => [
        'showErrors'     => false,
        'baseUri'        => '/',
    ],
    'database' => [
        'host'        => '',
        'username'    => '',
        'password'    => '',
        'port'        => '3306',
    ],
    'cache' => [
        'redis' => [
            "servers" => [
                [
                    'host'   => 'localhost',
                    'port'   => 6379,
                    'auth' => '',
                ],
            ],
            'prefix' => 'dashboard::',
        ],
    ]
];
