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
        'Options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ],
    'sqlsrv' => [
        'DSN' => $_ENV['SQLSRV_DSN'],
        'User' => $_ENV['SQLSRV_USER'],
        'Password' => $_ENV['SQLSRV_PASSWORD'],
        'Options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];
