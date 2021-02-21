<?php


namespace app\models;

use app\models\abstracts\Admin;
use app\database\Database;
use app\Validator;

class User extends Admin {

    protected $user_id;
    protected $user_firstname;
    protected $user_lastname;
    protected $user_email;
    protected $user_password;

    function setTable() {
        $this->_table = 'users';
    }

    function setName() {
        $this->_name = 'User';
    }

    public function save($router){
        $fields = $this->getFields();
        $this->user_password = password_hash($this->user_password, PASSWORD_DEFAULT);
        $router->db->save($this->_table, $fields);
    }

    public function createAuthHash(){
        $auth = $this->user_email.$this->user_password;
        return password_hash($auth, PASSWORD_DEFAULT);
    }

    public function validate() {
        $errors = [];
        if (!$this->user_firstname) {
            $errors[] = "Please add a firstname";
        }
        if (!$this->user_lastname) {
            $errors[] = "Please add a lastname";
        }
        if (!$this->user_email) {
            $errors[] = "Please add an email";
        }
        if (!$this->user_password) {
            $errors[] = "Please add a password";
        }
        if (!$this->user_confirmpassword) {
            $errors[] = "Please confirm your password";
        }
        if ($this->user_password !== $this->user_confirmpassword ) {
            $errors[] = "Your passwords do not match";
        }
        return $errors;
    }

}
