<?php


namespace app\models;


use app\database\Database;

class Room extends Base {

    public ?string $_table = 'rooms';

    public ?array $_detailsTypes = [
        'id' => "id",
        'type' => "select",
    ];

    public function getAllOptions($db) {
        return [
            'type' => ['Cat', 'Dog']
            ];
    }

    public ?array $_searchFields = [
        'id', 'type'
    ];

    public function validate($fields) {
        $errors = [];
        if (!$this->type) {
            $errors[] = "Please indicate the animal type";
        }
        return $errors;
    }

}
