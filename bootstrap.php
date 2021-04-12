<?php

use Dotenv\Dotenv;

require_once __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbCredentials = [
    'mysql' => [
        'DSN' => $_ENV['MYSQL_DSN'],
        'User' => $_ENV['MYSQL_USER'],
        'Password' => $_ENV['MYSQL_PASSWORD'],
        'AdminOptions' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],
    'pgsql' => [
        'DSN' => $_ENV['PGSQL_DSN'],
        'User' => $_ENV['PGSQL_USER'],
        'Password' => $_ENV['PGSQL_PASSWORD'],
        'AdminOptions' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],
    'sqlsrv' => [
        'DSN' => $_ENV['SQLSRV_DSN'],
        'User' => $_ENV['SQLSRV_USER'],
        'Password' => $_ENV['SQLSRV_PASSWORD'],
        'AdminOptions' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],
    'mongo' => [
        'uri' => $_ENV['MONGO_URI']
    ]
];
