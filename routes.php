<?php

/**
 * array $routes
 * [0] = string method
 * [1] = string url
 * [2] = array route [string controller, string method, string middleware]
 */

$routes = [
    ['get', '/animals', ['Frontend', 'animals']],
    ['get', '/admin/login', ['Auth', 'login', ['isGuest']]],

    ['post','/admin/login', ['Auth', 'login', ['isGuest']]],
    ['post','/admin/logout', ['Auth', 'logout', ['isAuth']]],

    ['get','/admin', ['Admin', 'admin', ['isAuth']]],

    ['get','/admin/animals', ['Animal', 'browse', ['isAuth']]],
    ['get','/admin/animals/details', ['Animal', 'save', ['isAuth']]],
    ['post','/admin/animals/details', ['Animal', 'save', ['isAuth']]],

    ['post','/admin/animals/delete', ['Animal', 'delete', ['isAuth']]],

    ['get','/admin/users', ['Admin', 'browse', ['isAuth']]],
    ['get','/admin/users/details', ['Admin', 'save', ['isAuth']]],
    ['post','/admin/users/details', ['Admin', 'save', ['isAuth']]],
    ['post','/admin/users/delete', ['Admin', 'delete', ['isAuth']]],

    ['get','/admin/owners', ['Admin', 'browse', ['isAuth']]],
    ['get','/admin/owners/details', ['Admin', 'save', ['isAuth']]],
    ['post','/admin/owners/details', ['Admin', 'save', ['isAuth']]],
    ['post','/admin/owners/delete', ['Admin', 'delete', ['isAuth']]],

    ['get','/admin/media', ['Media', 'browse', ['isAuth']]],
    ['get','/admin/media/details', ['Media', 'save', ['isAuth']]],
    ['post','/admin/media/details', ['Media', 'save', ['isAuth']]],
    ['post','/admin/media/delete', ['Media', 'delete', ['isAuth']]],

    ['get','/admin/rooms', ['Admin', 'browse', ['isAuth']]],
    ['get','/admin/rooms/details', ['Admin', 'save', ['isAuth']]],
    ['post','/admin/rooms/details', ['Admin', 'save', ['isAuth']]],
    ['post','/admin/rooms/delete', ['Admin', 'delete', ['isAuth']]],

    ['get','/admin/rehomings', ['Admin', 'browse', ['isAuth']]],
    ['get','/admin/rehomings/details', ['Admin', 'save', ['isAuth']]],
    ['post','/admin/rehomings/details', ['Admin', 'save', ['isAuth']]],
    ['post','/admin/rehomings/delete', ['Admin', 'delete', ['isAuth']]],

];


