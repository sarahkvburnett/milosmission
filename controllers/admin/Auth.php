<?php


namespace app\controllers\admin;

use app\database\Database;
use app\models\User;

class Auth {

    //todo fix login
       //TODO: need to redirect on login back to the initial url

    public function login($router){
        $errors = [];
        if ($_POST){
           $data = new User($_POST);
           $user = $router->db->fineOneByEmail('users', $data->email);
            if(!$user) {
                $errors[] = "Email address not found";
            }
//            if(password_verify($data->password , $user['password'])) {
//                $errors[] = "Password incorrect";
//            }
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

    public function logout(){
        setcookie("auth-user", "", time() - 3600);
        header('Location: /');
    }

}
