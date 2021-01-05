<?php


namespace app\models;


use app\database\Database;

class Room {
    public ?int $id;
    public ?string $type;
    public ?string $occupied;

    static public $inputs = [
        'id' => "id",
        'type' => "select",
        'occupied' => "select"
    ];


    static public function options() {
        function getOptions($table, $column){
            $options = ['N/A'];
            $query = 'SELECT '.$column.' FROM '.$table;
            $data = Database::$db->findAll($table, [], $query);
            if (empty($data)) return $options;
            foreach($data as $row){
                $options[] = $row[$column];
            };
            return $options;
        }
        return [
            'type' => ['Cat', 'Dog'],
            'occupied' => ['true', 'false']
        ];
    }

    static public $search = [
        'id', 'type', 'occupied'
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
        if (!$this->type) {
            $errors[] = "Please indicate the filetype";
        }
        if (!$this->type) {
            $errors[] = "Please indicate the current occupancy";
        }
        if (empty($errors)){
            $db = Database::$db;
            $db->save('rooms', $this);
        }
        return $errors;
    }
}
