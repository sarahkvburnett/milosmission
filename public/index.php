<?php

use app\controllers\admin\AnimalController;
use app\controllers\admin\AuthController;
use app\controllers\admin\Controller as AdminController;
use app\controllers\PostsController;
use app\Router;
use app\database\Database;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$database = new Database();
$router = new Router();

$router->get('/', [PostsController::class, 'index']);
$router->get('/posts', [PostsController::class, 'index']);
$router->get('/posts/create', [PostsController::class, 'create']);
$router->post('/posts/create', [PostsController::class, 'create']);
$router->post('/posts/delete', [PostsController::class, 'delete']);

$router->get('/admin/login', [AuthController::class, 'login', ['isGuest']]);
$router->post('/admin/login', [AuthController::class, 'login', ['isGuest']]);
$router->post('/admin/logout', [AuthController::class, 'logout', ['isAuth']]);

$router->get('/admin', [AdminController::class, 'index', ['isAuth']]);

$router->get('/admin/animals', [AnimalController::class, 'browse', ['isAuth']]);
$router->get('/admin/animals/details', [AnimalController::class, 'save', ['isAuth']]);
$router->post('/admin/animals/details', [AnimalController::class, 'save', ['isAuth']]);
$router->post('/admin/animals/delete', [AnimalController::class, 'delete', ['isAuth']]);

$router->resolve();
