<?php


namespace app\models;


use app\models\abstracts\Options;

class Room extends Options {

    protected string $table = 'rooms';
    protected string $idColumn = 'room_id';
    protected string $className = 'Room';
    protected string $name = 'room';

    protected array $rules = [
        'room_type' => ['required' => "Please indicate the animal type"]
    ];

  protected array $labels = [
        'room_id' => 'Number',
        'room_type' => 'Type',
        'animals' => 'Occupants'
    ];

    protected array $columns = [
        'room_id', 'room_type', 'animals'
    ];

   protected array $types = [
        'room_id' => "hidden",
        'room_type' => "select",
        'animals' => 'checkbox'
   ];

    protected array $searchables = [
        'room_id', 'room_type'
    ];

    function setOptions() {
        $this->addOption('room_type', $this->writeOptions(['Cat', 'Dog']));
        $this->addOption('animals', $this->findOptions('animals', 'animal_id', 'animal_name'));
    }

    function setCounts() {
        // TODO: Implement setCounts() method.
    }
}
