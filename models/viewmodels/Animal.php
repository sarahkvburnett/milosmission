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
            'room_id',
            'friend_id',
            'image'
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
                'rehoming_id' => 'Rehoming ID',
                'image' => 'Image'
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
            'media_subcategory' => 'hidden',
        ];
    }

    function setSearchables() {
       $this->searchables = [
               'animal_id', 'animal_name', 'animal_type', 'animal_breed', 'animal_age', 'animal_status'
       ];
    }

    function setOptions() {
        $this->addOption('animal_status', $this->writeOptions(['New', 'Waiting', 'Rehomed']));
        $this->addOption('animal_type', $this->writeOptions(['Cat', 'Dog']));
        $this->addOption('media_id', $this->fetchOptions('media', 'media_id', 'media_filename', ["media_type", "image"]));
        $this->addOption('friend_id', $this->fetchOptions('animals',  'animal_id', 'animal_name'));
        $this->addOption('room_id', $this->fetchOptions('rooms', 'room_id', 'room_id'));
        $this->addOption('owner_id', $this->fetchOptions('owners', 'owner_id', 'owner_firstname'));
        $this->addOption('rehoming_id', $this->fetchOptions('rehomings', 'rehoming_id', 'rehoming_id'));
    }
}
