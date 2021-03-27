<?php


namespace app\pages\page\admin;


use app\pages\page\abstracts\Admin;

class Animal extends Admin {

    function setController() {
        $this->controller = 'Admin';
    }

    function setModel() {
        $this->model = 'Animal';
    }

    function setRepo() {
        $this->repo = 'AnimalRepo';
    }

    function setTable() {
        $this->table = 'animals';
    }

    function setIdColumn(){
        $this->idColumn = 'animal_id';
    }

    function setName() {
        $this->name = 'Animals';
    }
}
