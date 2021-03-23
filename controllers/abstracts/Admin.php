<?php


namespace app\controllers\abstracts;

use app\database\Repository\Interfaces\Repository;
use app\Router;
use \Exception;
use app\Validator;

abstract class Admin {
    protected string $class;
    protected string $table;
    protected array $actions;
    protected array $search;
    protected array $counts;

    protected array $data;

    protected $repo;

    /**
     * Base constructor.
     * @throws Exception
     */
    public function __construct($repo){
        $this->repo = $repo;
        $this->setClass();
        $this->setTable();
        $this->setActions(strtolower($this->table));
        $this->setSearch();
        $this->setCounts();
        $this->setModelData($repo);
        $this->addDataField('id', $this->getIdentifier());
        $this->addDataField('search', $this->search);
        $this->addDataField('counts', $this->counts);
        $this->addDataField('title', $this->class);
        $this->addDataField('name', $this->class);
        $this->addDataField('actions', $this->actions);
    }

    abstract function setClass();
    abstract function setTable();

    /**
     * Execute browse route
     * @param Router $router
     */
    public function browse($router){
        $this->setBrowseData($this->search);
        $router->sendResponse('/admin/browse', $this->data);
    }

    /**
     * Execute details route
     * @param Router $router
     * @throws Exception
     */
     public function details($router){
         $this->setDetailsData();
         if ($router->isAPIRoute) $_POST = json_decode(file_get_contents('php://input'), true);
         if ($_POST) {
            $this->save($router, $_POST);
            $router->redirect($this->actions['browse']);
            return;
        }
        $router->sendResponse('/admin/details', $this->data);
    }

    /**
     * Save record(s) in db
     * @param Router $router
     * @param array $data - $_POST
     * @return string lastInsertId
     * @throws Exception
     */
    protected function save($router, $data){
        $array = Validator::sanitiseAll($data);
        $class = 'app\models\\'.$this->class;
        $model = new $class($array);
        $errors = $model->validate();
        if (!empty($errors)) {
            $this->addDataField('errors', $errors);
            throw new Exception('Bad Request', 400);
        }
        return $model->save($this->repo);
    }

    /**
     * Execute delete route
     * @param Router $router
     */
    public function delete($router){
        $id = $_POST['id'];
        $this->repo->delete($id);
        $router->redirect($this->actions['browse']);
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
     * Determine update/create data needed for details route
     */
    protected function setDetailsData(){
        if (isset($_GET['id'])) {
            $this->addDataField('fields', $this->repo->findOne($_GET['id']));
            $id = $this->data['fields'][$this->getIdentifier()];
            $this->addIdToActions($id);
        } else {
           $this->addDataField('fields', $this->repo->describe());
        }
    }

    /**
     * Add browse fields to $this->data using $this->addDataField($name, $data)
     * @param array $search
     */
    protected function setBrowseData($search = []){
        $this->addDataField('fields', $this->repo->findAll($search));
    }

    /**
     * Add key/value pair to data
     * @param string $name - name of field in response
     * @param $data - associated data (likely db result)
     */
    protected function addDataField($name, $data){
        $this->data[$name] = $data;
    }

    /**
     * Return name of id column for db queries
     */
    protected function getIdentifier(){
        return strtolower($this->class.'_id');
    }

    /**
     * Set search array from request values
     * @return array
     */
    protected function setSearch(){
        if (isset($_GET['searchColumn']) and isset($_GET['searchValue'])){
            $this->search = [$_GET['searchColumn'], $_GET['searchValue']];
        } else {
            $this->search = [];
        }
    }

    /**
     * Add fields from view model to data
     */
    protected function setModelData(){
        $class = 'app\models\viewmodels\\'.$this->class;
        $viewmodel = new $class($this->repo);
        $model = $viewmodel->getData();
        foreach ($model as $key => $data){
            $this->addDataField($key, $data);
        }
    }

    /**
     *  Return sql to add group contact column to query
     * @param $originColumn - column to group concat
     * @param $joinTable - table containing column
     * @return string
     */
    protected function addGroupConcatColumn($originColumn, $joinTable){
        return '(SELECT GROUP_CONCAT(t2.'.$originColumn.') FROM '.$joinTable.' t2 WHERE t1.'.$this->class.'_id = t2.'.$this->class.'_id) AS '.$joinTable.'';
    }

}
