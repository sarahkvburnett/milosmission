<?php


namespace app\model;


use app\model\abstracts\AdminOptionsCounts;
use app\model\abstracts\iCounts;

class Animal extends AdminOptionsCounts implements iCounts {

    protected string $table = 'animals';
    protected string $idColumn = 'animal_id';
    protected string $className = 'Animal';
    protected string $name = 'animal';

   protected array $rules = [
        'animal_name' => ['required' => 'Please add a a name'],
        'animal_type' => ['required' => 'Please indicate the animal\'s type'],
        'media_id' => ['required' => 'Please add an image'],
        'animal_status' => ['required' => 'Please indicate the animal\'s current status'],
   ];

    protected array $columns = [
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

    protected array $labels = [
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

    protected array $types = [
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
        'friend' => 'relation',
        'media' => 'relation',
    ];

    protected array $searchables = [
        'animal_id',
        'animal_name',
        'animal_type',
        'animal_breed',
        'animal_age',
        'animal_status'
    ];

    function setOptions() {
        $this->addOption('animal_status', $this->writeOptions(['New', 'Waiting', 'Rehomed']));
        $this->addOption('animal_type', $this->writeOptions(['Cat', 'Dog']));
        $this->addOption('media_id', $this->findOptions('media', 'media_id', 'media_filename'));
        $this->addOption('friend_id', $this->findOptions('animals', 'animal_id', 'animal_name'));
        $this->addOption('room_id', $this->findOptions('rooms', 'room_id', 'room_id'));
        $this->addOption('owner_id', $this->findOptions('owners', 'owner_id', 'owner_firstname'));
        $this->addOption('rehoming_id', $this->findOptions('rehomings', 'rehoming_id', 'rehoming_id'));
    }

    function setCounts(){
        parent::setCounts();
        $this->addSearchCount('New','animal_status', "new");
        $this->addSearchCount('Waiting', 'animal_status', "waiting");
        $this->addSearchCount('Rehomed','animal_status', "rehomed");
    }

}
