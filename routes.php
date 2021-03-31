<?php

/**
 * array $routes - [string $method, string $url, array $route [string $controller, string $method, array $middleware]
 */

$routes = [
    ['get', '/', ['Frontend', 'index']],

    ['get', '/admin/login', ['User', 'login', ['isGuest']]],
    ['post','/admin/login', ['User', 'login', ['isGuest']]],
    ['post','/admin/logout', ['User', 'logout', ['isAuth']]],

    ['get','/admin', ['Admin', 'admin', ['isAuth']]],

    ['get','/admin/animal/browse', ['Animal', 'browse', ['isAuth']]],
    ['get','/admin/animal/details', ['Animal', 'details', ['isAuth']]],
    ['post','/admin/animal/details', ['Animal', 'details', ['isAuth']]],

    ['post','/admin/animal/delete', ['Animal', 'delete', ['isAuth']]],

    ['get','/admin/user/browse', ['User', 'browse', ['isAuth']]],
    ['get','/admin/user/details', ['User', 'details', ['isAuth']]],
    ['post','/admin/user/details', ['User', 'details', ['isAuth']]],
    ['post','/admin/user/delete', ['User', 'delete', ['isAuth']]],

    ['get','/admin/owner/browse', ['Owner', 'browse', ['isAuth']]],
    ['get','/admin/owner/details', ['Owner', 'details', ['isAuth']]],
    ['post','/admin/owner/details', ['Owner', 'details', ['isAuth']]],
    ['post','/admin/owner/delete', ['Owner', 'delete', ['isAuth']]],

    ['get','/admin/media/browse', ['Media', 'browse', ['isAuth']]],
    ['get','/admin/media/details', ['Media', 'details', ['isAuth']]],
    ['post','/admin/media/details', ['Media', 'details', ['isAuth']]],
    ['post','/admin/media/delete', ['Media', 'delete', ['isAuth']]],

    ['get','/admin/room/browse', ['Room', 'browse', ['isAuth']]],
    ['get','/admin/room/details', ['Room', 'details', ['isAuth']]],
    ['post','/admin/room/details', ['Room', 'details', ['isAuth']]],
    ['post','/admin/room/delete', ['Room', 'delete', ['isAuth']]],

    ['get','/admin/rehoming/browse', ['Rehoming', 'browse', ['isAuth']]],
    ['get','/admin/rehoming/details', ['Rehoming', 'details', ['isAuth']]],
    ['post','/admin/rehoming/details', ['Rehoming', 'details', ['isAuth']]],
    ['post','/admin/rehoming/delete', ['Rehoming', 'delete', ['isAuth']]],

];


