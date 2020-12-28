<?php


namespace app\models;


class User {
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $password;
    public string $confirmpassword;

    public function __construct($data) {
        foreach($data as $key => $value){
            $this->$key = $value;
        }
    }

    public function createAuthHash(){
        $auth = $this->email.$this->password;
        return password_hash($auth, PASSWORD_DEFAULT);
    }

    public function save(){
        $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
    }

    public function login(){

    }

    public function logout(){

    }

}