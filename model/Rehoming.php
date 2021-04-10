<?php


namespace app\model;


use app\model\abstracts\AdminOptions;

class Rehoming extends AdminOptions {

    protected string $table = 'rehomings';
    protected string $idColumn = 'rehoming_id';
    protected string $className = 'Rehoming';
    protected string $name = 'rehoming';

    //todo need to reformat date

   protected array $rules = [
        'rehoming_date' => ['required' => "Please add the date"],
        'rehoming_status' => ['required' => "Please select status"],
        'owner_id' => ['required' => "Please add an owner"]
    ];

   protected array $labels = [
        'rehoming_id' => 'ID',
        'rehoming_date' => 'Date',
        'rehoming_status' => 'Status',
        'owner_id' => 'Owner',
        'owner_name' => 'Owner',
        'animals' => 'Animals'
    ];

    protected array $columns = [
        'rehoming_id', 'rehoming_date', 'rehoming_status', 'animals', 'owner_name',
    ];

    protected array $types = [
        'rehoming_id' => 'hidden',
        'rehoming_date' => 'date',
        'rehoming_status' => 'select',
        'owner_id' => 'select',
        'owner_name' => 'hidden',
        'animals' => 'checkbox'
    ];

    protected array $searchables = [
        'rehoming_id', 'rehoming_date', 'rehoming_status', 'owner_name'
    ];

    function setOptions() {
        $this->addOption('rehoming_status', $this->writeOptions(['Pending', 'Rehomed']));
        $this->addOption('owner_id', $this->findOptions('owners', 'owner_id', 'owner_firstname'));
        $this->addOption('animals', $this->findOptions('animals', 'animal_id', 'animal_name'));
    }

}
