<?php

use app\controllers\admin\AnimalController;
use app\controllers\admin\AuthController;
use app\controllers\admin\MediaController;
use app\controllers\admin\OwnerController;
use app\controllers\admin\RoomController;
use app\controllers\admin\UserController;
use app\controllers\Controller;
use app\Router;
use app\database\Database;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$database = new Database();
$router = new Router();

$router->get('/', [Controller::class, 'index']);

$router->get('/admin/login', [AuthController::class, 'login', ['isGuest']]);
$router->post('/admin/login', [AuthController::class, 'login', ['isGuest']]);
$router->post('/admin/logout', [AuthController::class, 'logout', ['isAuth']]);

$router->get('/admin', [Controller::class, 'admin', ['isAuth']]);

$router->get('/admin/animals', [AnimalController::class, 'browse', ['isAuth']]);
$router->get('/admin/animals/details', [AnimalController::class, 'save', ['isAuth']]);
$router->post('/admin/animals/details', [AnimalController::class, 'save', ['isAuth']]);
$router->post('/admin/animals/delete', [AnimalController::class, 'delete', ['isAuth']]);

$router->get('/admin/users', [UserController::class, 'browse', ['isAuth']]);
$router->get('/admin/users/details', [UserController::class, 'save', ['isAuth']]);
$router->post('/admin/users/details', [UserController::class, 'save', ['isAuth']]);
$router->post('/admin/users/delete', [UserController::class, 'delete', ['isAuth']]);

$router->get('/admin/owners', [OwnerController::class, 'browse', ['isAuth']]);
$router->get('/admin/owners/details', [OwnerController::class, 'save', ['isAuth']]);
$router->post('/admin/owners/details', [OwnerController::class, 'save', ['isAuth']]);
$router->post('/admin/owners/delete', [OwnerController::class, 'delete', ['isAuth']]);

$router->get('/admin/media', [MediaController::class, 'browse', ['isAuth']]);
$router->get('/admin/media/details', [MediaController::class, 'save', ['isAuth']]);
$router->post('/admin/media/details', [MediaController::class, 'save', ['isAuth']]);
$router->post('/admin/media/delete', [MediaController::class, 'delete', ['isAuth']]);

$router->get('/admin/rooms', [RoomController::class, 'browse', ['isAuth']]);
$router->get('/admin/rooms/details', [RoomController::class, 'save', ['isAuth']]);
$router->post('/admin/rooms/details', [RoomController::class, 'save', ['isAuth']]);
$router->post('/admin/rooms/delete', [RoomController::class, 'delete', ['isAuth']]);

$router->resolve();
