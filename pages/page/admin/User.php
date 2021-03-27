<?php


namespace app\pages\page\admin;


use app\pages\page\abstracts\Admin;

class User extends Admin {

    function setController() {
        $this->controller = 'Admin';
    }

    function setModel() {
        $this->model = 'User';
    }

    function setRepo() {
        $this->repo = 'AdminRepo';
    }

    function setTable() {
        $this->table = 'users';
    }

    function setIdColumn(){
        $this->idColumn = 'user_id';
    }

    function setName() {
        $this->name = 'Users';
    }
}
