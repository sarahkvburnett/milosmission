<?php

use app\FailedValidation;
use app\Options;
use app\repository\OptionsRepo;
use app\Router;
use app\database\Database;

require_once "../bootstrap.php";
require_once "../routes.php";

$dbConnections['mysql'] = Database::factory('PDO', $dbCredentials['mysql']);

$router = new Router($dbConnections);
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
catch (FailedValidation $e){
    $router->handleFailedValidation($e);
}

