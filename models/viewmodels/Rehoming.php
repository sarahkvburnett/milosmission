<?php


namespace app\models\viewmodels;


use app\models\viewmodels\abstracts\Options;

class Rehoming extends Options {

    //todo need to add someway of displaying the animal(s)

    //todo need to reformat date

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
            'owner_name' => 'hidden'
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
    }
}
