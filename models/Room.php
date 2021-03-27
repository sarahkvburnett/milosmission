<?php


namespace app\models;


use app\models\abstracts\AdminOptions;

class Room extends AdminOptions {

    function setRules(){
        $this->rules = [
              'room_type' => ['required' => "Please indicate the animal type"]
        ];
    }

    function setLabels() {
        $this->labels = [
            'room_id' => 'Number',
            'room_type' => 'Type',
            'animals' => 'Occupants'
        ];
    }

    function setColumns() {
        $this->columns = [
            'room_id', 'room_type', 'animals'
        ];
    }

    function setTypes() {
       $this->types = [
            'room_id' => "hidden",
            'room_type' => "select",
            'animals' => 'checkbox'
       ];
    }

    function setSearchables() {
        $this->searchables = [
            'room_id', 'room_type'
        ];
    }

    function setOptions() {
        $this->addOption('room_type', $this->writeOptions(['Cat', 'Dog']));
        $this->addOption('animals', $this->fetchOptions('animals', 'animal_id', 'animal_name'));
    }

    function setCounts() {
        // TODO: Implement setCounts() method.
    }
}
