<?php


namespace app\controllers\admin;


use app\database\Database;
use app\models\Room;
use app\Validator;

class RoomController extends BaseController {
    public $name = 'Rooms';
    public $table = 'rooms';
    public $urls = [
        'browse' => '/admin/rooms',
        'details' => '/admin/rooms/details',
        'delete' => '/admin/rooms/delete'
    ];

    public function __construct() {
        $this->model = new Room();
    }

}
