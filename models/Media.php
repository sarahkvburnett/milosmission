<?php


namespace app\models;


use app\database\Database;

class Media {
    public ?int $id;
    public ?string $filename;
    public ?string $type;
    public ?string $category;
    public ?string $subcategory;

    static public $inputs = [
        'id' => "id",
        'filename' =>  "file",
        'type' => "select",
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
        $animalNames = getOptions('animals',  'name');
        $animalIds = getOptions('animals', 'id');
        return [
            'type' => ['Image', 'Video'],
            'animal_name' => $animalNames,
            'animal_id' => $animalIds,
        ];
    }

    static public $search = [
        'id', 'filename', 'type', 'category', 'subcategory'
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
        if (!$this->filename) {
            $errors[] = "Please add a file";
        }
        if (!$this->type) {
            $errors[] = "Please indicate the filetype";
        }
        if (!$this->category) {
            $errors[] = "Please indicate the category";
        }
        if (!$this->subcategory) {
            $errors[] = "Please indicate the subcategory";
        }
        if (empty($errors)){
            $db = Database::$db;
            $db->save('media', $this);
        }
        return $errors;
    }


}
