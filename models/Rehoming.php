<?php


namespace app\models;


class Rehoming extends Base {

    public ?string $_table = 'rehomings';

    public ?array $_detailsTypes = [
        'id' => 'id',
        'date' => 'date',
        'status' => 'select',
        'owner_id' => 'select',
        'animal_id' => 'select'
    ];

    public ?array $_searchFields = [
        'id', 'date', 'status', 'owner'
    ];

    public function getAllOptions($db) {
        $ownerIds = $this->getOptions($db, 'owners', 'firstname');
        $animalIds = $this->getOptions($db, 'animals', 'name');
        return [
            'status' => ['Pending', 'Rehomed'],
            'owner_id' => $ownerIds,
            'amimals' => $animalIds
        ];
    }

    public function validate($fields) {
        $errors = [];
        if (!$this->date) {
            $errors[] = "Please add the date";
        }
        if (!$this->status) {
            $errors[] = "Please select status";
        }
        if (!$this->address) {
            $errors[] = "Please add an owner";
        }
        return $errors;
    }
}
