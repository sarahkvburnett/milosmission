<?php


namespace app\models;


use app\database\Database;

class Media extends Base {

    public ?string $_table = 'media';

    public ?array $_detailsTypes = [
        'id' => "id",
        'filename' =>  "file",
        'type' => "select",
    ];

    public function getAlloptions($db) {
        $animalNames = $this->getOptions($db,'animals',  'name');
        $animalIds = $this->getOptions($db,'animals', 'id');
        return [
            'type' => ['Image', 'Video'],
            'animal_name' => $animalNames,
            'animal_id' => $animalIds,
        ];
    }

    public ?array $_searchFields = [
        'id', 'filename', 'type', 'category', 'subcategory'
    ];

    public function validate($fields) {
        $errors = [];
        if (!$this->filename) {
            $errors[] = "Please add a file";
        }
//        if (!$this->type) {
//            $errors[] = "Please indicate the filetype";
//        }
//        if (!$this->category) {
//            $errors[] = "Please indicate the category";
//        }
//        if (!$this->subcategory) {
//            $errors[] = "Please indicate the subcategory";
//        }
        return $errors;
    }

}
