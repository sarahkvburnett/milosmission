<?php


namespace app\models;

use app\database\Database;
use app\models\abstracts\Admin;

class Animal extends Admin {

    protected $animal_id;
    protected $animal_name;
    protected $animal_type;
    protected $animal_breed;
    protected $animal_colour;
    protected $animal_age;
    protected $animal_status;
    protected $media_id;
    protected $room_id;
    protected $friend_id;
    protected $owner_id;
    protected $rehoming_id;

    public function setTable() {
        $this->_table = 'animals';
    }

    public function setName() {
        $this->_name = 'animal';
    }

    public function validate() {
        $errors = [];
        if (!$this->animal_name) {
            $errors[] = "Please add a name";
        }
        if (!$this->animal_type) {
            $errors[] = "Please indicate the animal's type";
        }
        if (!$this->media_id) {
            $errors[] = "Please add an image";
        }
        if (!$this->animal_status) {
            $errors[] = "Please indicate the animal's current status";
        }
        return $errors;
    }

}
