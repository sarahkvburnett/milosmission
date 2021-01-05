<?php


namespace app\models;


use app\database\Database;

class Owner {
    public ?int $id;
    public ?string $firstname;
    public ?string $lastname;
    public ?string $address;
    public ?string $postcode;
    public ?string $animal;
    public ?string $status;

    static public $inputs = [
        'id' => "id",
        'animal' => 'select',
        'status' => "select",
    ];

    static public $options = [
        'animal' => ['Cat', 'Dog'],
        'status' => ['New', 'Waiting', 'Rehomed'],
    ];

    static public $search = [
        'id', 'firstname', 'lastname', 'postcode', 'animal', 'status'
    ];

    public function __construct($data) {
        foreach($data as $key => $value){
            if (!empty($value)){
                $this->$key = $value;
            } else {
                $this->$key = null;
            }
        }
    }

    public function save(){
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
        if (empty($errors)){
            $db = Database::$db;
            $db->save('owners', $this);
        }
        return $errors;
    }
}
