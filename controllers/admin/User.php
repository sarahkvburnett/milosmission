<?php


namespace app\controllers\admin;


use app\classes\FailedValidation;
use app\classes\Request;
use app\classes\Router;
use app\controllers\abstracts\Admin;
use app\controllers\abstracts\iController;

class User extends Admin implements iController {

    //Add password hashing to save method
    public function save($data){
        $data['user_password'] = $this->genAuthHash($data);
        parent::save($data);
    }

    //Add auth routes
    //todo
    public function login(Router $router){
        $request = Request::getInstance();
        if ($request->hasPost()) {
            $user = $request->getPost();
            try {
                if (!isset($user['user_email'])) throw new FailedValidation(["Please enter your email address"]);
                if (!isset($user['user_password'])) throw new FailedValidation(["Please enter your password"]);
                $dbUser = $this->repo->findOneByEmail($user['user_email']);
                if (!$dbUser) throw new FailedValidation(["Email address not found"]);
                $authHash = $this->genAuthHash($user);
                setcookie("auth-user", $authHash, time() + (86400 * 30));
                $router->redirect('/admin');
                return;
            } catch (FailedValidation $e) {
                $this->errors = $e->getErrors();
            }
        }
        $router->sendResponse('/admin/auth/login', $this->getErrors());
    }

    public function logout(Router $router){
        setcookie("auth-user", "", time() - 3600);
        $router->redirect('/');
    }

    public function getErrors(){
        return isset($this->errors) ? ['errors', $this->errors] : [];
    }

    public function genAuthHash($user){
        $auth = $user['user_email'].$user['user_password'];
       return password_hash($auth, PASSWORD_DEFAULT);
    }

}
