<?php


namespace app\models;

use app\models\abstracts\Admin;
use app\database\Database;

class Room extends Admin {

    protected $room_id;
    protected $room_type;

    function setTable() {
        $this->_table = 'rooms';
    }

    function setName() {
        $this->_name = 'Room';
    }

    public function validate() {
        $errors = [];
        if (!$this->room_type) {
            $errors[] = "Please indicate the animal type";
        }
        return $errors;
    }

}
