<?php


namespace app\models;


use app\database\Database;
use app\models\abstracts\Admin;

class Owner extends Admin {

    protected $owner_id;
    protected $owner_firstname;
    protected $owner_lastname;
    protected $owner_address;
    protected $owner_postcode;
    protected $owner_animal;
    protected $owner_status;

    function setTable() {
        $this->_table = 'owners';
    }

    function setName() {
        $this->_name = 'Owner';
    }


    public function validate() {
        $errors = [];
        if (!$this->owner_firstname) {
            $errors[] = "Please add a firstname";
        }
        if (!$this->owner_lastname) {
            $errors[] = "Please add a lastname";
        }
        if (!$this->owner_address) {
            $errors[] = "Please add an address";
        }
        if (!$this->owner_postcode) {
            $errors[] = "Please add a postcode";
        }
        if (!$this->owner_animal) {
            $errors[] = "Select the animal type to be rehomed";
        }
        if (!$this->owner_status) {
            $errors[] = "Please select the owner's status";
        }
        return $errors;
    }

}
