<?php


namespace app\pages\page\admin;


use app\pages\page\abstracts\Admin;

class Media extends Admin {

    function setController() {
        $this->controller = 'Media';
    }

    function setModel() {
        $this->model = 'Media';
    }

    function setRepo() {
        $this->repo = 'MediaRepo';
    }

    function setTable() {
        $this->table = 'media';
    }

    function setIdColumn(){
        $this->idColumn = 'media_id';
    }

    function setName() {
        $this->name = 'Media';
    }
}
