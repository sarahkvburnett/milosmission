<?php


namespace app\controller\admin;

use app\classes\FailedValidation;
use app\classes\Request;
use app\classes\Response;
use app\controller\abstracts\Controller;
use app\controller\abstracts\iController;
use \Exception;
use app\classes\Validator;

class Admin extends Controller implements iController {
    protected array $search;
    protected array $fields;
    protected ?array $errors;
    protected ?string $id;

    public function __construct($repo) {
        parent::__construct($repo);
        $request = Request::getInstance();
        $this->search = $request->getSearch();
        $this->id = $request->hasId() ? $request->getId() : null;
    }

    /**
     * Execute browse route
     * @param Response $response
     */
    public function browse($response){
        $this->setBrowseData($this->search);
        $response->send('/admin/browse', $this->getData());
    }

    /**
     * Execute details route
     * @param Response $response
     * @throws Exception
     */
     public function details($response){
         $this->setDetailsData();
         $request = Request::getInstance();
         if ($request->hasPost()) {
             try {
                 $this->save($request->getPost());
                 $response->redirect($this->actions['browse']);
                 return;
             } catch (FailedValidation $e) {
                 $this->errors = $e->getErrors();
             }
        }
        $response->send('/admin/details', $this->getData());
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
     * @param Response $response
     */
    public function delete($response){
        $this->repo->delete($this->id);
        $response->redirect($this->actions['browse']);
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
