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
    public $data = [];

    abstract function __construct();

    public function browse($router){
        $search = $this->setSearchData($_GET);
        $this->setBrowseData($router,  $search);
        $this->setModelData($router);
        return $router->renderView('/admin/browse', $this->data);
    }

     public function save($router){
        $this->setDetailsData($router);
         $this->setModelData($router);
         if ($_POST) {
            $array = Validator::sanitiseAll($_POST);
            $model = new $this->model($array);
            $errors = $model->save($router->db);
            if(empty($errors)) {
                $router->redirect($this->urls['browse'], $this->data);
            }
            $this->data['errors'] = $errors;
        }
        return $router->renderView('/admin/details', $this->data);
    }

    public function delete($router){
        $id = $_POST['id'];
        //todo: add where need to delete row from other table;
        $router->db->deleteOneById($this->table, $id);
        $router->redirect($this->urls['browse'], $this->data);
    }

    public function setModelData($router){
        $this->data['actions'] = $this->urls;
        $this->data['inputs'] = $this->model->_detailsTypes;
        $this->data['options'] = $this->model->getAllOptions($router->db);
        $this->data['searchables'] = $this->model->_searchFields;
    }

    public function setBrowseData($router, $search){
        $this->data['fields'] = $this->getBrowseData($router, $search);
    }

    public function setDetailsData($router){
        $fields = [];
        if (isset($_GET['id'])) {
            $fields = $this->getDetailsData($router);
            $fields = $fields[0];
        } else {
            $data = $router->db->describe($this->table);
            foreach ($data as $item){
                $fields[$item['Field']] = '';
            }
        }
        $this->data['fields'] = $fields;
    }

    public function getBrowseData($router, $search){
        return $router->db->findAll($this->table, $search);
    }

    public function getDetailsData($router){
        return $router->db->findOneById($this->table, $_GET['id']);
    }

    public function setSearchData($params){
        $searchColumn = $params['searchColumn'] ?? '';
        $searchValue = $params['searchValue'] ?? '';
        $search = [
            'column' => $searchColumn,
            'value' => $searchValue
        ];
        $this->data['search'] = $search;
        return $search;
    }
}
