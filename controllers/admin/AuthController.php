<?php


namespace app\controllers\admin;

use app\database\Database;
use app\models\User;

class AuthController {

    static public function register(){

    }

    //TODO: need to redirect on login back to the initial url

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
                setcookie("auth-user", $authHash, time() + (86400 * 30));
                header( 'Location: /admin');
            }
        }
       $router->renderView('/admin/auth/login', [
           'errors'=> $errors
       ]);
    }

    static public function logout(){
        setcookie("auth-user", "", time() - 3600);
        header('Location: /');
    }

}
