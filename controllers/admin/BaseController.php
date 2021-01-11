<?php


namespace app\controllers\admin;

use app\Validator;

abstract class BaseController {

    public $name; //titlecase
    public $table;
    public $urls = [
        'browse' => '',
        'details' => '',
        'delete' => ''
    ];

    public $model;

    abstract function __construct();

    public function browse($router){
        $search = $this->getSearch($_GET);
        $fields = $this->getBrowseFields($this->table, $router,  $search);
        return $router->renderView('/admin/browse', [
            'fields' => $fields,
            'title' => $this->name,
            'searchables' => $this->model->_searchFields,
            'actions' => $this->urls,
            'search' => $search,
        ]);
    }

     public function save($router){
        $fields = $this->getDetailsFields($this->table, $router);
        $errors = [];
        if ($_POST) {
            $array = Validator::sanitiseAll($_POST);
            $model = new $this->model($array);
            $errors = $model->save($router->db, $fields);
            if(empty($errors)) {
                $router->redirect($this->urls['browse']);
            }
        }
        return $router->renderView('/admin/details', [
            'fields' => $fields,
            'errors' => $errors,
            'title' => $this->name,
            'actions' => $this->urls,
            'inputs' => $this->model->_detailsTypes,
            'options' => $this->model->getAllOptions($router->db)
        ]);
    }

    public function delete($router){
        $id = $_POST['id'];
        $router->db->deleteOneById($this->table, $id);
        $router->redirect($this->urls['browse']);
    }

    public function getBrowseFields($table, $router, $search){
        return $router->db->findAll($this->table, $search);
    }

    public function getDetailsFields($table, $router){
        $fields = [];
        if (isset($_GET['id'])) {
            $fields = $router->db->findOneById($table, $_GET['id']);
            $fields = $fields[0];
        } else {
            $data = $router->db->describe($table);
            foreach ($data as $item){
                $fields[$item['Field']] = '';
            }
        }
        return $fields;
    }

    public function getSearch($params){
        $searchColumn = $params['searchColumn'] ?? '';
        $searchItem = $params['searchItem'] ?? '';
        return [
            'column' => $searchColumn,
            'item' => $searchItem
        ];
    }
}
