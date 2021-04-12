<?php

use app\classes\Router;
use app\database\Connection;
use \app\classes\Response;

require_once "../bootstrap.php";
require_once "../routes.php";

$dbConnections = Connection::getInstance();
$dbConnections->init($dbCredentials)
    ->add('mysql', 'PDO')
//    ->add('sqlsrv', 'PDO')
    ->add('pgsql', 'PDO')
    ->add('mongo', 'Mongo');

$router = new Router();
foreach($routes as $route){
    [$method, $url, $controller] = $route;
    $router->$method("/api$url", $controller);
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
    $response = Response::getInstance();
    $response->error($e);
}
