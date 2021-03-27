<?php


namespace app\models;


use app\models\abstracts\AdminOptions;

class Animal extends AdminOptions{

    public function setRules(){
        $this->rules = [
            'animal_name' => ['required' => 'Please add a a name'],
            'animal_type' => ['required' => 'Please indicate the animal\'s type'],
            'media_id' => ['required' => 'Please add an image'],
            'animal_status' => ['required' => 'Please indicate the animal\'s current status'],
        ];
    }

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
        $this->addOption('media_id', $this->findOptions('media', 'media_id', 'media_filename'));
        $this->addOption('friend_id', $this->findOptions('rooms', 'room_id', 'room_id'));
        $this->addOption('owner_id', $this->findOptions('owners', 'owner_id', 'owner_firstname'));
        $this->addOption('rehoming_id', $this->findOptions('rehomings', 'rehoming_id', 'rehoming_id'));
    }

    protected function setCounts(){
        $this->addCount('All', $this->repo->count(), '/admin/animals');
        $this->addCount('New', $this->repo->count('animal_status', "new"), '?searchValue=new&searchColumn=animal_status');
        $this->addCount('Waiting', $this->repo->count('animal_status', "waiting"), '?searchValue=waiting&searchColumn=animal_status');
        $this->addCount('Rehomed', $this->repo->count('animal_status', "rehomed"), '?searchValue=rehomed&searchColumn=animal_status');
    }

}
