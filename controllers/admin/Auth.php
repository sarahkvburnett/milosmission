<?php


namespace app\controllers\admin;

use app\database\Database;
use app\models\User;
use app\Router;

class Auth {

    protected array $errors = [];

    //todo fix login
       //TODO: need to redirect on login back to the initial url

    public function login(Router $router){
        if ($_POST){
            $user = new User($_POST);
            $this->validate($user);
            if (empty($this->errors)){
                $dbUser = $router->db->select('users')->where(['user_email', $user->user_email])->fetch();
                if(!$dbUser) {
                    $this->addError("Email address not found");
                }
//                if(!password_verify($user->user_password , $dbUser['user_password'])) {
//                    $this->addError("Password incorrect");
//                }
                if(empty($this->errors)){
                    $authHash = $user->createAuthHash();
                    setcookie("auth-user", $authHash, time() + (86400 * 30));
                    $router->redirect('/admin');
                }
            }
        }
       $router->sendResponse('/admin/auth/login', [
           'errors'=> $this->errors
       ]);
    }

    public function logout(Router $router){
        setcookie("auth-user", "", time() - 3600);
        $router->redirect('/');
    }

    public function validate(User $user){
        if (!$user->user_email) {
            $this->addError("Please add an email");
        }
        if (!$user->user_password) {
            $this->addError("Please add a password");
        }
    }

    public function addError($msg){
        $this->errors[] = $msg;
    }

}
