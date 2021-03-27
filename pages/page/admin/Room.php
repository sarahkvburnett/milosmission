<?php


namespace app\pages\page\admin;


use app\pages\page\abstracts\Admin;

class Room extends Admin {

    function setController() {
        $this->controller = 'GroupAnimal';
    }

    function setModel() {
        $this->model = 'Room';
    }

    function setRepo() {
        $this->repo = 'GroupAnimalRepo';
    }

    function setTable() {
        $this->table = 'rooms';
    }

    function setIdColumn(){
        $this->idColumn = 'room_id';
    }

    function setName() {
        $this->name = 'Rooms';
    }
}
