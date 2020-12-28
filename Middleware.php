<?php


namespace app;


class Middleware {
    //Auth middleware
    static public function isAuth(){
        if (!isset($_COOKIE['auth-user'])) {
            header('Location: /admin/login');
            exit();
        }
    }

    static public function isGuest(){
        if (isset($_COOKIE['auth-user'])) {
            header('Location: /admin/login');
            exit();
        }
    }

}