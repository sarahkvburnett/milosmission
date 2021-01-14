<?php


namespace app;

class Middleware {
    //Auth middleware
    static public function isAuth(){
//        if (!isset($_COOKIE['auth-user'])) {
//            header('Content-type: application/json', true, 401);
//            echo json_encode(['error' => [
//                'code' => 401,
//                'message' => 'Admin page',
//            ]]);
////            exit();
////            header('Location: /admin/login');
////            exit();
//        }
    }

    static public function isGuest(){
        if (isset($_COOKIE['auth-user'])) {
            header('Content-type: application/json', true, 401);
            echo json_encode(['error' => [
                'code' => 401,
                'message' => 'Guest page',
            ]]);
            exit();
//            header('Location: /admin');
//            exit();
        }
    }

}
