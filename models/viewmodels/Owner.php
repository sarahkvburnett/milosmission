<?php


namespace app\models\viewmodels;


use app\models\viewmodels\abstracts\AdminOptions;

class Owner extends AdminOptions {

    function setLabels() {
        $this->labels = [
            "owner_id" => "ID",
            "owner_firstname" => "First Name",
            "owner_lastname" => "Last Name",
            "owner_address" => "Address",
            "owner_postcode" => "Post Code",
            "owner_animal" => "Type",
            "owner_status" => "Status",
            "animals" => "Animals"
        ];
    }

    function setColumns() {
       $this->columns = [
           "owner_id", "owner_firstname", "owner_lastname", "owner_address", "owner_postcode", "owner_animal", "owner_status", "animals"
       ];
    }

    function setTypes() {
        $this->types = [
            'owner_id' => "hidden",
            'owner_animal' => 'select',
            'owner_status' => "select",
            'animals' => 'checkbox'
        ];
    }

    function setSearchables() {
        $this->searchables = [
            'owner_id', 'owner_firstname', 'owner_lastname', 'owner_postcode', 'owner_animal', 'owner_status'
        ];
    }

    function setOptions() {
        $this->addOption('owner_animal', $this->writeOptions(['Cat', 'Dog']));
        $this->addOption('owner_status', $this->writeOptions(['New', 'Waiting', 'Rehomed']));
        $this->addOption('animals', $this->fetchOptions('animals', 'animal_id', 'animal_name'));
    }
}
