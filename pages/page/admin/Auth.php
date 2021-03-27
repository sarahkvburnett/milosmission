<?php


namespace app\pages\page\admin;


use app\pages\page\abstracts\Admin;

class Auth extends Admin {

    function setController() {
        $this->controller = 'Admin';
    }

    function setModel() {
        $this->model = 'User';
    }

    function setRepo() {
       $this->repo = 'Admin';
    }

    function setTable() {
        $this->table = 'users';
    }

    function setName() {
        $this->name = 'Users';
    }
}
