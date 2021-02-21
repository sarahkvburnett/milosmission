<?php


namespace app\controllers\admin;


use app\controllers\abstracts\Admin;

class User extends Admin {

    function setClass() {
        $this->class = 'User';
    }

    function setTable() {
        $this->table = 'users';
    }
}
