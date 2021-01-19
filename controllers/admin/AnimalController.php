<?php


namespace app\controllers\admin;

use app\database\Database;
use app\models\Animal;
use app\Validator;

class AnimalController extends BaseController {
    public $name = 'Animal'; //titlecase
    public $table = 'animals';
    public $model;
    public $urls = [
        'browse' => '/admin/animals',
        'details' => '/admin/animals/details',
        'delete' => '/admin/animals/delete'
    ];

    public function __construct() {
        $this->model = new Animal();
    }

    public function getBrowseData($router, $search = []){
       return $this->joinAnimalFields($router,  $search, ['id', 'name', 'type', 'breed', 'colour', 'age', 'status']);
    }

    public function getDetailsData($router){
        return $this->joinAnimalFields($router);
    }

    public function setDetailsData($router){
        parent::setDetailsData($router);
        $this->data['friends'] = $this->joinAnimalFields($router, ['column' => 'id', 'value' => $this->data['fields']['friend_id']]);
        $this->data['media'] = $router->db->executeQuery('SELECT j.id, j.animal_id, j.image_id, m.filename, m.id as image_id FROM animal_media j, media m WHERE j.image_id = m.id AND j.animal_id='.$this->data['fields']['id']);
    }

    public function setBrowseData($router, $search){
        parent::setBrowseData($router, $search);
        $this->data['counts'] = $this->getCounts($router);
    }

    private function getCounts($router){
        $all = $router->db->count($this->table);
        $new = $router->db->count($this->table, "WHERE status = 'new'");
        $waiting = $router->db->count($this->table, "WHERE status = 'waiting'");
        $rehomed = $router->db->count($this->table, "WHERE status = 'rehomed'");
        return [
            'all' => $all,
            'new' => $new,
            'waiting' => $waiting,
            'rehomed' => $rehomed
        ];
    }

    private function joinAnimalFields($router, $search = [], $animalFields= ['id', 'name', 'type', 'breed', 'colour', 'age', 'status', 'room_id', 'friend_id', 'owner_id', 'rehoming_id']){
        return $router->db->join([
            'name' => 'animals',
            'fields' => $animalFields,
            'on' => 'image_id'
        ], [
            'name' => 'media',
            'fields' => ['filename as image'],
            'on' => 'id'
        ],
            $search);
    }

}
