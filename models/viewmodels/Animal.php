<?php


namespace app\models\viewmodels;


use app\models\viewmodels\abstracts\Options;

class Animal extends Options {

    function setColumns(){
        $this->columns = [
            'animal_id',
            'animal_name',
            'animal_type',
            'animal_breed',
            'animal_colour',
            'animal_age',
            'animal_status',
            'media_id',
            'room_id',
            'friend_id',
            'owner_id',
            'rehoming_id',
        ];
    }

    function setLabels(){
        $this->labels = [
                'animal_id' =>'ID',
                'animal_name' =>'Name',
                'animal_type' =>'Type',
                'animal_breed' =>'Breed',
                'animal_colour' =>'Colour',
                'animal_age' =>'Age',
                'animal_status' =>'Status',
                'media_id' =>'Image',
                'room_id' =>'Room',
                'friend_id' =>'Friend',
                'owner_id' =>'New Owner',
                'rehoming_id' => 'Rehoming ID'
        ];
    }


    function setTypes() {
        $this->types = [
            'animal_id' => "hidden",
            'animal_status' => "select",
            'animal_type' => "select",
            'room_id' => "select",
            'friend_id' => "select",
            'owner_id' => "select",
            'rehoming_id' => "select",
            'media_id' => "select",
            'media_filename' => 'hidden',
            'media_type' => 'hidden',
            'media_category' => 'hidden',
            'media_subcategory' => 'hidden'
        ];
    }

    function setSearchables() {
       $this->searchables = [
               'animal_id', 'animal_name', 'animal_type', 'animal_breed', 'animal_age', 'animal_status'
       ];
    }

    function setOptions() {
        $statuses = $this->writeOptions(['New', 'Waiting', 'Rehomed']);
        $types = $this->writeOptions(['Cat', 'Dog']);
        $mediaIds = $this->fetchOptions('media', 'media_id', 'media_filename', ["media_type", "image"]);
        $friendIds = $this->fetchOptions('animals',  'animal_id', 'animal_name');
        $roomIds = $this->fetchOptions('rooms', 'room_id', 'room_id');
        $ownerIds = $this->fetchOptions('owners', 'owner_id', 'owner_firstname');
        $rehomingIds = $this->fetchOptions('rehomings', 'rehoming_id', 'rehoming_id');
        $this->options = [
            'animal_status' => $statuses,
            'animal_type' => $types,
            'media_id' => $mediaIds,
            'friend_id' => $friendIds,
            'room_id' => $roomIds,
            'owner_id' => $ownerIds,
            'rehoming_id' => $rehomingIds,
        ];
    }
}
