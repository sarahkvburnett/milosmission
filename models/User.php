<?php


namespace app\models;


use app\database\Database;
use app\Validator;

class User extends Base {

    public ?string $_table = 'users';

    public ?array $_searchFields = [
        'id' => "id",
        'password' => 'password',
        'confirmpassword' => 'password',
        'email' => 'email',
    ];

    public ?array $_detailsTypes = [
        'id', 'firstname', 'lastname', 'email'
    ];

    public function getAllOptions($db) {
    }

    public function save($router){
        $fields = $this->getFields();
        $errors = $validator->validate($fields);
        if (empty($errors)){
            $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
            $db->save($this->_table, $fields);
        }
        return $errors;
    }

    public function createAuthHash(){
        $auth = $this->email.$this->password;
        return password_hash($auth, PASSWORD_DEFAULT);
    }

    public function validate($fields) {
        $errors = [];
        if (!$this->firstname) {
            $errors[] = "Please add a firstname";
        }
        if (!$this->lastname) {
            $errors[] = "Please add a lastname";
        }
        if (!$this->email) {
            $errors[] = "Please add an email";
        }
        if (!$this->password) {
            $errors[] = "Please add a password";
        }
        if (!$this->confirmpassword) {
            $errors[] = "Please confirm your password";
        }
        if ($this->password !== $this->confirmpassword ) {
            $errors[] = "Your passwords do not match";
        }
        return $errors;
    }

}
