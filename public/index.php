<?php

use app\Router;
use app\database\Database;
use Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';
require_once "../routes.php";

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$dbCredentials = [
    'dbDSN' => $_ENV['DB_DSN'],
    'dbUser' => $_ENV['DB_USER'],
    'dbPassword' => $_ENV['DB_PASSWORD'],
    'dbOptions' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];

$database = new Database($dbCredentials);
$router = new Router($database);

foreach($routes as $route){
    [$method, $url, $controller] = $route;
    $router->$method('/api'.$url, $controller);
    $router->$method($url, $controller);
}

try {
    $uri = strtok($_SERVER['REQUEST_URI'], '?');
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $router->findRoute($uri, $method);
    $router->executeMiddleware();
    $router->resolve();
}
catch (Error | Exception $e){
    $router->handleException($e);
}

