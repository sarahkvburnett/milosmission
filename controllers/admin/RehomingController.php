<?php


namespace app\controllers\admin;

use app\models\Rehoming;

class RehomingController extends BaseController {
    public $name = 'Rehomings';
    public $table = 'rehomings';
    public $urls = [
        'browse' => '/admin/rehomings',
        'details' => '/admin/rehomings/details',
        'delete' => 'admin/rehomings/delete'
    ];

    public function __construct(){
        $this->model = new Rehoming();
    }

}
