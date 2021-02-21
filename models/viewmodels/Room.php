<?php


namespace app\models\viewmodels;


class Room extends abstracts\Options {

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
        ];
    }

    function setSearchables() {
        $this->searchables = [
            'room_id', 'room_type'
        ];
    }

    function setOptions() {
        $this->addOption('room_type', $this->writeOptions(['Cat', 'Dog']));
    }
}
