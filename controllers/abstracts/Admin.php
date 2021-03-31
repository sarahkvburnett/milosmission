<?php


namespace app\controllers\abstracts;

use app\classes\FailedValidation;
use app\classes\Page;
use app\classes\Request;
use app\classes\Router;
use app\controllers\abstracts\iController;
use \Exception;
use app\classes\Validator;

abstract class Admin implements iController {
    protected array $actions;
    protected array $search;
    protected array $fields;
    protected ?array $errors;
    protected ?string $id;

    protected $repo;
    protected $model;

    /**
     * PageInterface constructor.
     * @param $repo
     */
    public function __construct($repo){
        $request = Request::getInstance();
        $page = Page::getInstance();
        $this->model = $page->getModel();
        $this->actions = $page->getActions();
        $this->search = $request->getSearch();
        $this->id = $request->hasId() ? $request->getId() : null;
        $this->repo = $repo;
        $this->setModelData();
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
         $request = Request::getInstance();
         if ($request->hasPost()) {
             try {
                 $this->save($request->getPost());
                 $router->redirect($this->actions['browse']);
                 return;
             } catch (FailedValidation $e) {
                 $this->errors = $e->getErrors();
             }
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
        $model = $this->validate($data);
        if(isset($this->id)){
            return $this->repo->update($this->id, $model);
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
    protected function setModelData(){
        $data = $this->model->getData();
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

    /**
     * Validate model
     * @return array
     * @throws FailedValidation
     */
    protected function validate($data){
        $validator = new Validator($data);
        return $validator->sanitise()->validate($this->rules)->getFields();
    }


}
