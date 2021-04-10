<?php


namespace app\controller\admin;


use app\classes\FailedValidation;
use app\classes\Request;
use app\classes\Router;
use app\controller\abstracts\Admin;

class User extends Admin {

    //Add password hashing to save method
    public function save($data){
        $data['user_password'] = $this->genAuthHash($data);
        parent::save($data);
    }


    public function genAuthHash($user){
        $auth = $user['user_email'].$user['user_password'];
       return password_hash($auth, PASSWORD_DEFAULT);
    }

}
