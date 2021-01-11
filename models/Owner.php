<?php


namespace app\models;


use app\database\Database;

class Owner extends Base {

    public ?string $_table = 'owners';

    public ?array $_detailsTypes = [
        'id' => "id",
        'animal' => 'select',
        'status' => "select",
    ];

    public function getAllOptions($db) {
        return [
            'animal' => ['Cat', 'Dog'],
            'status' => ['New', 'Waiting', 'Rehomed']
        ];
    }

    public ?array $_searchFields = [
        'id', 'firstname', 'lastname', 'postcode', 'animal', 'status'
    ];

    public function validate($fields) {
        $errors = [];
        if (!$this->firstname) {
            $errors[] = "Please add a firstname";
        }
        if (!$this->lastname) {
            $errors[] = "Please add a lastname";
        }
        if (!$this->address) {
            $errors[] = "Please add an address";
        }
        if (!$this->postcode) {
            $errors[] = "Please add a postcode";
        }
        if (!$this->animal) {
            $errors[] = "Select the animal type to be rehomed";
        }
        if (!$this->status) {
            $errors[] = "Please select the owner's status";
        }
        return $errors;
    }

}
