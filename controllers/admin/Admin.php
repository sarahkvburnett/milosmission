<?php


namespace app\controllers\abstracts;

use app\FailedValidation;
use app\pages\Page;
use app\Request;
use app\Router;
use \Exception;
use app\Validator;

class Admin {
    protected array $actions;
    protected array $search;
    protected array $fields;
    protected string $id;

    protected $repo;
    protected $model;
    protected $viewmodel;

    /**
     * Base constructor.
     * @param $repo
     */
    public function __construct($repo){
        $request = Request::getInstance();
        $page = Page::getInstance();
        $this->model = $page->getModel();
        $this->actions = $page->getActions();
        $this->search = $request->getSearch();
        $this->id = $request->hasId() ? $request->getId() : null;
        $this->rules = $this->model->getRules();
        $this->repo = $repo;
        $this->setModelData($repo);
    }

    /**
     * Set the action urls for the view
     * @param string $name
     */
    protected function setActions($name){
        $this->actions['browse'] = '/admin/'.$name;
        $this->actions['details'] = '/admin/'.$name.'/details';
        $this->actions['delete'] = '/admin/'.$name.'/delete';
    }

    /**
     * Add the id to the details/delete action urls
     * @param int $id
     */
    protected function addIdToActions($id){
        $this->actions['details'] .= "?id=".$id;
        $this->actions['delete'] .= "?id=".$id;
    }


    /**
     * Execute browse route
     * @param Router $router
     */
    public function browse($router){
        $this->setBrowseData($this->search);
        $router->sendResponse('/admin/browse', $this->getData());
    }

    /**
     * Execute details route
     * @param Router $router
     * @throws Exception
     */
     public function details($router){
         $this->setDetailsData();
         //todo move to request class
         if ($router->isAPIRoute) $_POST = json_decode(file_get_contents('php://input'), true);
         if ($_POST) {
             try {
                 $this->save($_POST);
             } catch (FailedValidation $e) {
                 $this->errors = $e->getErrors();
             }
            $router->redirect($this->actions['browse']);
            return;
        }
        $router->sendResponse('/admin/details', $this->getData());
    }

    /**
     * Save record(s) in db
     * @param array $data - $_POST
     * @return string lastInsertId
     * @throws Exception
     */
    protected function save($data){
        $validator = new Validator($data);
        $model = $validator->validate($this->rules)->sanitiseAll();
        if(isset($this->id)){
            return $this->repo->update($model);
        } else {
            return $this->repo->insert($model);
        }
    }

    /**
     * Execute delete route
     * @param Router $router
     */
    public function delete($router){
        $this->repo->delete($this->id);
        $router->redirect($this->actions['browse']);
    }

    /**
     * Determine update/create data needed for details route
     */
    protected function setDetailsData(){
        if ($this->id) {
            $this->fields = $this->repo->findOne($this->id);
        } else {
           $this->fields = $this->repo->describe();
        }
    }

    /**
     * Add browse fields to $this->data using $this->addDataField($name, $data)
     * @param array $search
     */
    protected function setBrowseData($search = []){
        $this->fields = $this->repo->findAll($search);
    }

    /**
     * Add fields from view model to data
     */
    protected function setModelData($repo){
        $model = new $this->model($repo);
        $data = $model->getData();
        foreach ($data as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * @return array
     */
    protected function getData(){
        $array = get_object_vars($this);
        unset($array['repo']);
        unset($array['model']);
        return $array;
    }


}
