<?php


namespace app\pages\page\admin;


use app\pages\page\abstracts\Admin;

class Rehoming extends Admin {

    function setController() {
        $this->controller = 'GroupAnimal';
    }

    function setModel() {
        $this->model = 'Rehoming';
    }

    function setRepo() {
        $this->repo = 'GroupAnimalRepo';
    }

    function setTable() {
        $this->table = 'rehomings';
    }

    function setIdColumn(){
        $this->idColumn = 'rehoming_id';
    }

    function setName() {
        $this->name = 'Rehomings';
    }
}
