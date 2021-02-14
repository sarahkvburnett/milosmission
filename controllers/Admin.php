<?php


namespace app\controllers;

use \Exception;
use app\Validator;

class Admin {
    protected string $class;
    protected string $table;
    protected array $actions;
    protected array $search;

    protected $data;

    public function __construct($router){
        if (!isset($this->class)) {
            $router->handleError('Class Not Found', 404);
        };
        $this->setActions(strtolower($this->table));
        $this->data['actions'] = $this->actions;
        $this->search = $this->setSearch();
    }

    public function browse($router){
        $this->setModelData($router);
        $this->setBrowseData($router,  $this->search);
        $this->addDataField('title', $this->class);
        $this->addDataField('name', $this->class);
        $this->addDataField('actions', $this->actions);
        $this->addDataField('id', $this->nameIdColumn());
        $this->addDataField('search', $this->search);
        return $router->renderView('/admin/browse', $this->data);
    }

     public function save($router){
        $this->setModelData($router);
         $this->setDetailsData($router);
         $this->addDataField('title', $this->class);
         $this->addDataField('actions', $this->actions);
//         $_POST = json_decode(file_get_contents('php://input'), true);
         if ($_POST) {
            $array = Validator::sanitiseAll($_POST);
            $class = 'app\models\\'.$this->class;
            $model = new $class($array);
            $errors = $model->save($router);
            $this->addDataField('errors', $errors);
            if (!empty($errors)) {
                throw new Exception('Bad Request', 400);
            }
            return $router->redirect($this->actions['browse']);
        }
        return $router->renderView('/admin/details', $this->data);
    }

    public function delete($router){
        $id = $_POST['id'];
        $router->db->delete($this->table)->where([$this->nameIdColumn(), $id])->execute();
        return $router->redirect($this->actions['browse']);
    }

    protected function setActions($name){
        $this->actions['browse'] = '/admin/'.$name;
        $this->actions['details'] = '/admin/'.$name.'/details';
        $this->actions['delete'] = '/admin/'.$name.'/delete';
    }

    protected function addIdToActions($id){
        $this->actions['details'] .= "?id=".$id;
        $this->actions['delete'] .= "?id=".$id;
    }

    protected function setDetailsData($router){
        if (isset($_GET['id'])) {
            $this->setExistingDetailsData($router);
            $id = $this->data['fields'][$this->nameIdColumn()];
            $this->addIdToActions($id);
        } else {
           $this->setNewDetailsData($router);
        }
    }

    protected function setBrowseData($router, $search = []){
        $data = $router->db
                ->find($this->table)
                ->where($search)
                ->fetchAll();
        $this->addDataField('fields', $data);
    }

    protected function setExistingDetailsData($router){
        $data = $router->db
                ->find($this->table)
                ->where([$this->nameIdColumn(), $_GET['id']])
                ->fetch();
        $this->addDataField('fields', $data);
    }

    protected function setNewDetailsData($router){
        $data = $router->db->describe($this->table)->fetchAll();
        $fields = [];
        foreach ($data as $item){
            $fields[$item['Field']] = '';
        }
        $this->addDataField('fields', $fields);
    }

    protected function addDataField($name, $data){
        $this->data[$name] = $data;
    }

    protected function nameIdColumn(){
        return strtolower($this->class.'_id');
    }

    protected function setSearch(){
        if (isset($_GET['searchColumn']) and isset($_GET['searchValue'])){
            return [$_GET['searchColumn'], $_GET['searchValue']];
        }
        return [];
    }

    protected function setModelData($router){
        $class = 'app\models\viewmodels\\'.$this->class;
        $viewmodel = new $class($router);
        $model = $viewmodel->getData();
        foreach ($model as $key => $data){
            $this->addDataField($key, $data);
        }
    }

}
