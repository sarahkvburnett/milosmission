<?php


namespace app\controller\admin;


use app\classes\FailedValidation;
use app\classes\Request;
use app\classes\response;
use app\controller\abstracts\Controller;

class Auth extends Controller {

    //todo - this doesn't work with api
    public function login($response){
        $request = Request::getInstance();
        if ($request->hasPost()) {
            $user = $request->getPost();
            try {
                if (!isset($user['user_email'])) throw new FailedValidation(["Please enter your email address"]);
                if (!isset($user['user_password'])) throw new FailedValidation(["Please enter your password"]);
                $dbUser = $this->repo->findUserByEmail($user['user_email']);
                if (!$dbUser) throw new FailedValidation(["Email address not found"]);
                $authHash = $this->genAuthHash($user);
                setcookie("auth-user", $authHash, time() + (86400 * 30));
                $response->redirect('/admin');
                return;
            } catch (FailedValidation $e) {
                $this->errors = $e->getErrors();
            }
        }
        $response->send('/admin/login', $this->getData());
    }

    public function logout($response){
        setcookie("auth-user", "", time() - 3600);
        $response->redirect('/');
    }

    //todo you copied this from user model bro
    public function genAuthHash($user){
        $auth = $user['user_email'].$user['user_password'];
        return password_hash($auth, PASSWORD_DEFAULT);
    }

}
