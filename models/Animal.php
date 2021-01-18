<?php


namespace app\models;


use app\database\Database;

class Animal extends Base {
    public ?string $_table = 'animals';

    public ?array $_detailsTypes = [
        'id' => "id",
        'status' => "select",
        'type' => "select",
        'image_id' => "select",
        'friend_id' => "select",
        'room_id' => "select",
        'owner_id' => "select",
        'rehoming_id' => "select",
        'image' => "hidden"
    ];

    public function getAllOptions($db) {
        $imageIds = $this->getOptions($db,'media', 'id', 'WHERE type="image"');
        $friendIds = $this->getOptions($db, 'animals',  'id');
        $roomIds = $this->getOptions($db,'rooms', 'id');
        $ownerIds = $this->getOptions($db,'owners', 'id');
        $rehomingIds = $this->getOptions($db,'owners', 'id');
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

    public ?array $_searchFields = [
        'id', 'name', 'type', 'breed', 'age', 'status'
    ];

    public function validate($fields) {
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
        return $errors;
    }

}
