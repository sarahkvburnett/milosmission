<?php

use Dotenv\Dotenv;

require_once __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbCredentials = [
    'mysql' => [
        'dbDSN' => $_ENV['DB_DSN'],
        'dbUser' => $_ENV['DB_USER'],
        'dbPassword' => $_ENV['DB_PASSWORD'],
        'dbOptions' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];
