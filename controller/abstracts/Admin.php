<?php


namespace app\controller\abstracts;

use app\classes\FailedValidation;
use app\classes\Page;
use app\classes\Request;
use app\classes\Router;
use app\controller\abstracts\iController;
use app\model\abstracts\iModel;
use app\repository\abstracts\iRepo;
use \Exception;
use app\classes\Validator;

abstract class Admin extends Controller implements iController {
    protected array $search;
    protected array $fields;
    protected ?array $errors;
    protected ?string $id;

    public function __construct($repo) {
        parent::__construct($repo);
        $request = Request::getInstance();
        $page = Page::getInstance();
        $this->search = $request->getSearch();
        $this->id = $request->hasId() ? $request->getId() : null;
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
        return isset($this->id) ? $this->repo->update($this->id, $model) : $this->repo->insert($model);
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
        $this->fields = $this->id ? $this->repo->findOne($this->id) : $this->repo->describe();
    }

    /**
     * Add browse fields to $this->data using $this->addDataField($name, $data)
     * @param array $search
     */
    protected function setBrowseData($search = []){
        $this->fields = $this->repo->findAll($search);
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
