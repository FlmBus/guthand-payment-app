<?php

return [
    'views_dir' => realpath(__DIR__ . '/app/views/'),
    'database' => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'payment_app',
        'username'  => 'root',
        'password'  => '1234',
        'charset'   => 'utf8mb4',
        'collation' => 'utf8mb4_general_ci',
        'prefix'    => '',
    ]
];
