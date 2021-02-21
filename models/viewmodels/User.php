<?php


namespace app\models\viewmodels;

use app\models\viewmodels\abstracts\Admin;

class User extends Admin {

    //todo confirm password missing from details

    function setClass() {
        $this->class = 'User';
    }

    function setTable() {
        $this->table = 'users';
    }

    function setLabels() {
        $this->labels = [
            'user_id' => 'ID',
            'user_firstname' => 'First Name',
            'user_lastname' => 'Last Name',
            'user_email' => 'Email',
            'user_password' => 'Password'
        ];
    }

    function setColumns() {
        $this->columns = [
            'user_id', 'user_firstname', 'user_lastname', 'user_email'
        ];
    }

    function setTypes() {
        $this->types = [
            'user_id' => 'hidden',
            'user_password' => 'password',
            'user_confirmpassword' => 'password',
            'user_email' => 'email'
        ];
    }


    function setSearchables() {
        $this->searchables = [
            'user_id', 'user_email'
        ];
    }


}
