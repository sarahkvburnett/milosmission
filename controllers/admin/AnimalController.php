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

    public function getBrowseFields($table, $router, $search = []){
       return $this->joinAnimalFields($router, $search);
    }

    public function getDetailsFields($table, $router){
        $fields = [];
        if (isset($_GET['id'])) {
            $fields = $this->joinAnimalFields($router);
            $fields = $fields[0];
        } else {
            $data = $router->db->describe($table);
            foreach ($data as $item){
                $fields[$item['Field']] = '';
            }
        }
        return $fields;
    }

    private function joinAnimalFields($router, $search = []){
        return $router->db->join([
            'name' => 'animals',
            'fields' => ['id', 'name', 'type', 'breed', 'colour', 'age', 'status', 'room_id', 'friend_id', 'owner_id', 'rehoming_id'],
            'on' => 'image_id'
        ], [
            'name' => 'media',
            'fields' => ['filename as image'],
            'on' => 'id'
        ],
            $search);
    }

}
