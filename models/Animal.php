<?php


namespace app\models;


use app\database\Database;

class Animal {
    public ?int $id;
    public ?string $name;
    public ?string $type;
    public ?string $breed;
    public ?string $colour;
    public ?int $age;
    public ?string $image;
    public ?string $status;
    public ?int $room_id;
    public ?int $friend_id;
    public ?int $owner_id;
    public ?int $rehoming_id;

    static public $inputs = [
        'id' => "hidden",
        'status' => "select",
//        'image' =>  "file", TODO: file uploader
        'type' => "select"
    ];

    static public $options = [
        'status' => ['New', 'Waiting', 'Rehomed'],
        'type' => ['Cat', 'Dog']
    ];

    static public $search = [
        'name', 'type', 'breed', 'age', 'status'
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
        if (!$this->name) {
            $errors[] = "Please add a name";
        }
        if (!$this->type) {
            $errors[] = "Please indicate the animal's type";
        }
        if (!$this->image) {
            $errors[] = "Please add an image";
        }
        if (!$this->status) {
            $errors[] = "Please indicate the animal's current status";
        }
        if (empty($errors)){
            $db = Database::$db;
            $db->save('animals', $this);
        }
        return $errors;
    }



}
