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
        $query = 'SELECT a.id, a.name, a.type, a.breed, a.colour, a.age, a.status, m.filename as image, a.room_id as room_id, a.friend_id, a.owner_id, a.rehoming_id FROM animals a LEFT JOIN media m ON m.id = a.image_id';
        return $router->db->executeQuery($query);
    }
}
