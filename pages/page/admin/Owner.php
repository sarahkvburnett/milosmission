<?php


namespace app\pages\page\admin;


use app\pages\page\abstracts\Admin;

class Owner extends Admin {

    function setController() {
        $this->controller = 'GroupAnimal';
    }

    function setModel() {
        $this->model = 'Owner';
    }

    function setRepo() {
        $this->repo = 'GroupAnimalRepo';
    }

    function setTable() {
        $this->table = 'owners';
    }

    function setIdColumn(){
        $this->idColumn = 'owner_id';
    }

    function setName() {
        $this->name = 'Owners';
    }
}
