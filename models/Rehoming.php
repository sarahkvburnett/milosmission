<?php


namespace app\models;

use app\models\abstracts\Admin;

class Rehoming extends Admin {

    protected $rehoming_id;
    protected $rehoming_date;
    protected $rehoming_status;
    protected $owner_id;

    function setTable() {
        $this->_table = 'rehomings';
    }

    function setName() {
        $this->_name = 'Rehoming';
    }

    public function validate() {
        $errors = [];
        if (!$this->rehoming_date) {
            $errors[] = "Please add the date";
        }
        if (!$this->rehoming_status) {
            $errors[] = "Please select status";
        }
        if (!$this->owner_id) {
            $errors[] = "Please add an owner";
        }
        return $errors;
    }

}
