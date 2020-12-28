<?php


namespace app\controllers\admin;

use app\Database;
use app\models\User;

class AuthController {

    static public function register(){

    }

    static public function login($router){
        $errors = [];
        if ($_POST){
           $data = new User($_POST);
           $user = Database::$db->getUserByEmail($data);
            if(!$user) {
                $errors[] = "Email address not found";
            }
            if(password_verify ($data->password , $user['password'])) {
                $errors[] = "Password incorrect";
            }
            if(empty($errors)){
                $authHash = $data->createAuthHash();
                setcookie("auth-user", $authHash);
                header( 'Location: /admin');
            }
        }
       $router->renderView('/admin/auth/login', [
           'errors'=> $errors
       ]);
    }

    static public function logout(){

    }

}