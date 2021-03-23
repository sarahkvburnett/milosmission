<?php

/**
 * array $routes - [string $method, string $url, array $route [string $controller, string $method, array $middleware]
 */

$routes = [
    ['get', '/', ['Frontend', 'index']],

    ['get', '/admin/login', ['Auth', 'login', ['isGuest']]],
    ['post','/admin/login', ['Auth', 'login', ['isGuest']]],
    ['post','/admin/logout', ['Auth', 'logout', ['isAuth']]],

    ['get','/admin', ['Base', 'admin', ['isAuth']]],

    ['get','/admin/animals', ['Animal', 'browse', ['isAuth']]],
    ['get','/admin/animals/details', ['Animal', 'details', ['isAuth']]],
    ['post','/admin/animals/details', ['Animal', 'details', ['isAuth']]],

    ['post','/admin/animals/delete', ['Animal', 'delete', ['isAuth']]],

    ['get','/admin/users', ['User', 'browse', ['isAuth']]],
    ['get','/admin/users/details', ['User', 'details', ['isAuth']]],
    ['post','/admin/users/details', ['User', 'details', ['isAuth']]],
    ['post','/admin/users/delete', ['User', 'delete', ['isAuth']]],

    ['get','/admin/owners', ['Owner', 'browse', ['isAuth']]],
    ['get','/admin/owners/details', ['Owner', 'details', ['isAuth']]],
    ['post','/admin/owners/details', ['Owner', 'details', ['isAuth']]],
    ['post','/admin/owners/delete', ['Owner', 'delete', ['isAuth']]],

    ['get','/admin/media', ['Media', 'browse', ['isAuth']]],
    ['get','/admin/media/details', ['Media', 'details', ['isAuth']]],
    ['post','/admin/media/details', ['Media', 'details', ['isAuth']]],
    ['post','/admin/media/delete', ['Media', 'delete', ['isAuth']]],

    ['get','/admin/rooms', ['Room', 'browse', ['isAuth']]],
    ['get','/admin/rooms/details', ['Room', 'details', ['isAuth']]],
    ['post','/admin/rooms/details', ['Room', 'details', ['isAuth']]],
    ['post','/admin/rooms/delete', ['Room', 'delete', ['isAuth']]],

    ['get','/admin/rehomings', ['Rehoming', 'browse', ['isAuth']]],
    ['get','/admin/rehomings/details', ['Rehoming', 'details', ['isAuth']]],
    ['post','/admin/rehomings/details', ['Rehoming', 'details', ['isAuth']]],
    ['post','/admin/rehomings/delete', ['Rehoming', 'delete', ['isAuth']]],

];


