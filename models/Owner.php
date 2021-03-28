<?php


namespace app\models;


use app\models\abstracts\Options;

class Owner extends Options {

    protected string $table = 'owners';
    protected string $idColumn = 'owner_id';
    protected string $className = 'Owner';
    protected string $name = 'owner';

    function setRules(){
        $this->rules = [
           'owner_firstname' => ['required' => "Please add a firstname"],
            'owner_address' => ['required' => "Please add a a lastname"],
            'owner_postcode' => ['required' => "Please add an address"],
            'owner_animal' => ['required' => "Select the animal type to be rehomed"],
            'owner_status' => ['required' => "Please select the owner's status"]
            ];
    }

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

    function setCounts() {
        // TODO: Implement setCounts() method.
    }
}
