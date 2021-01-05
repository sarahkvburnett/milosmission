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
    public ?string $image_id;
    public ?string $status;
    public ?int $room_id;
    public ?int $friend_id;
    public ?int $owner_id;
    public ?int $rehoming_id;

    static public $inputs = [
        'id' => "id",
        'status' => "select",
        'type' => "select",
        'image_id' => "select",
        'friend_id' => "select",
        'room_id' => "select",
        'owner_id' => "select",
        'rehoming_id' => "select",
    ];


    static public function options() {
        function getOptions($table, $column, $where = null){
            $options = ['N/A'];
            $query = 'SELECT '.$column.' FROM '.$table;
            if (!empty($where)){
                $query = $query." ".$where;
            }
            $data = Database::$db->findAll($table, [], $query);
            if (empty($data)) return $options;
            foreach($data as $row){
                $options[] = $row[$column];
            };
            return $options;
        }
        $imageIds = getOptions('media', 'id', 'WHERE type="image"');
        $friendIds = getOptions('animals',  'id');
        $roomIds = getOptions('rooms', 'id');
        $ownerIds = getOptions('owners', 'id');
        $rehomingIds = getOptions('owners', 'id');
        return [
            'status' => ['New', 'Waiting', 'Rehomed'],
            'type' => ['Cat', 'Dog'],
            'image_id' => $imageIds,
            'friend_id' => $friendIds,
            'room_id' => $roomIds,
            'owner_id' => $ownerIds,
            'rehoming_id' => $rehomingIds,
        ];
    }

    static public $search = [
        'id', 'name', 'type', 'breed', 'age', 'status'
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
        if (!$this->image_id) {
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
