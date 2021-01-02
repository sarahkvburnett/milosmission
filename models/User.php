<?php


namespace app\models;


use app\database\Database;

class User {
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $password;
    public string $confirmpassword;

    public function __construct($data) {
        foreach($data as $key => $value){
            if (!empty($value)){
                $this->$key = $value;
            } else {
                $this->$key = null;
            }
        }
    }

    public function createAuthHash(){
        $auth = $this->email.$this->password;
        return password_hash($auth, PASSWORD_DEFAULT);
    }

    static public $inputs = [
        'id' => "hidden",
        'password' => 'password',
        'confirmpassword' => 'confirmpassword',
        'email' => 'email',
    ];

    static public $search = [
        'firstname', 'lastname', 'email'
    ];

    public function save(){
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
        if (empty($errors)){
            $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
            $db = Database::$db;
            $db->save('users', $this);
        }
        return $errors;
    }


}
