<?php

use app\classes\Router;
use app\database\Connection;

require_once "../bootstrap.php";
require_once "../routes.php";

$dbConnections = Connection::setInstance($dbCredentials);
$dbConnections->add('mysql', 'PDO');
//$dbConnections->add('sqlsrv', 'PDO');

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
    $router->handleException($e);
}
