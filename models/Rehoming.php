<?php


namespace app\models;


use app\models\abstracts\AdminOptions;

class Rehoming extends AdminOptions {

    //todo need to reformat date

    function setRules(){
        $this->rules = [
            'rehoming_date' => ['required' => "Please add the date"],
            'rehoming_status' => ['required' => "Please select status"],
            'owner_id' => ['required' => "Please add an owner"]
        ];
    }

    function setLabels() {
        $this->labels = [
            'rehoming_id' => 'ID',
            'rehoming_date' => 'Date',
            'rehoming_status' => 'Status',
            'owner_id' => 'Owner',
            'owner_name' => 'Owner',
            'animals' => 'Animals'
        ];
    }

    function setColumns() {
        $this->columns = [
            'rehoming_id', 'rehoming_date', 'rehoming_status', 'animals', 'owner_name',
        ];
    }

    function setTypes() {
        $this->types = [
            'rehoming_id' => 'hidden',
            'rehoming_date' => 'date',
            'rehoming_status' => 'select',
            'owner_id' => 'select',
            'owner_name' => 'hidden',
            'animals' => 'checkbox'
        ];
    }

    function setSearchables() {
        $this->searchables = [
            'rehoming_id', 'rehoming_date', 'rehoming_status', 'owner_name'
        ];
    }

    function setOptions() {
        $this->addOption('rehoming_status', $this->writeOptions(['Pending', 'Rehomed']));
        $this->addOption('owner_id', $this->fetchOptions('owners', 'owner_id', 'owner_firstname'));
        $this->addOption('animals', $this->fetchOptions('animals', 'animal_id', 'animal_name'));
    }

    function setCounts() {
        // TODO: Implement setCounts() method.
    }
}
