<?php

use app\controllers\admin\AnimalController;
use app\controllers\admin\AuthController;
use app\controllers\admin\MediaController;
use app\controllers\admin\OwnerController;
use app\controllers\admin\RehomingController;
use app\controllers\admin\RoomController;
use app\controllers\admin\UserController;
use app\controllers\Controller;
use app\Router;
use app\database\Database;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$database = new Database();
$router = new Router($database);

$controller = new Controller();
$auth = new AuthController();
$rehoming = new RehomingController();
$animal = new AnimalController();
$media = new MediaController();
$owner = new OwnerController();
$room = new RoomController();
$user = new UserController();

//$router->get('/', [$controller, 'index']);
$router->get('/api/animals', [$controller, 'animals']);

$router->get('/admin/login', [$auth, 'login', ['isGuest']]);
$router->post('/admin/login', [$auth, 'login', ['isGuest']]);
$router->post('/admin/logout', [$auth, 'logout', ['isAuth']]);

$router->get('/admin', [$controller, 'admin', ['isAuth']]);

$router->get('/api/admin/animals', [$animal, 'browse', ['isAuth']]);
$router->get('/api/admin/animals/details', [$animal, 'save', ['isAuth']]);
$router->post('/api/admin/animals/details', [$animal, 'save', ['isAuth']]);

$router->get('/api/admin/users', [$user, 'browse', ['isAuth']]);
$router->get('/api/admin/users/details', [$user, 'save', ['isAuth']]);
$router->post('/api/admin/users/details', [$user, 'save', ['isAuth']]);
$router->post('/api/admin/users/delete', [$user, 'delete', ['isAuth']]);

$router->get('/api/admin/owners', [$owner, 'browse', ['isAuth']]);
$router->get('/api/admin/owners/details', [$owner, 'save', ['isAuth']]);
$router->post('/api/admin/owners/details', [$owner, 'save', ['isAuth']]);
$router->post('/api/admin/owners/delete', [$owner, 'delete', ['isAuth']]);

$router->get('/api/admin/media', [$media, 'browse', ['isAuth']]);
$router->get('/api/admin/media/details', [$media, 'save', ['isAuth']]);
$router->post('/api/admin/media/details', [$media, 'save', ['isAuth']]);
$router->post('/api/admin/media/delete', [$media, 'delete', ['isAuth']]);

$router->get('/api/admin/rooms', [$room, 'browse', ['isAuth']]);
$router->get('/api/admin/rooms/details', [$room, 'save', ['isAuth']]);
$router->post('/api/admin/rooms/details', [$room, 'save', ['isAuth']]);
$router->post('/api/admin/rooms/delete', [$room, 'delete', ['isAuth']]);

$router->get('/api/admin/rehomings', [$rehoming, 'browse', ['isAuth']]);
$router->get('/api/admin/rehomings/details', [$rehoming, 'save', ['isAuth']]);
$router->post('/api/admin/rehomings/details', [$rehoming, 'save', ['isAuth']]);
$router->post('/api/admin/rehomings/delete', [$rehoming, 'delete', ['isAuth']]);

$router->resolve();
