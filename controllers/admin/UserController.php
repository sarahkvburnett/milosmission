<?php


namespace app\controllers\admin;


use app\database\Database;
use app\models\User;

class UserController extends BaseController {
    public $name = 'Users';
    public $table = 'users';
    public $urls = [
        'browse' => '/admin/users',
        'details' => '/admin/users/details',
        'delete' => '/admin/users/delete'
    ];

    public function __construct() {
        $this->model = new User();
    }

}
