<?php


namespace app\controllers\admin;


use app\database\Database;
use app\models\Owner;

class OwnerController extends BaseController {
    public $name = 'Owners';
    public $table = 'owners';
    public $urls = [
        'browse' => '/admin/owners',
        'details' => '/admin/owners/details',
        'delete' => '/admin/owners/delete'
    ];

    public function __construct() {
        $this->model = new Owner();
    }

}
