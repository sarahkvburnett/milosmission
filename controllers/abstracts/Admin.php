<?php


namespace app\controllers\abstracts;

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

    /**
     * Admin constructor.
     * @param Router $router
     * @throws Exception
     */
    public function __construct($router){
        $this->setClass();
        $this->setTable();
        $this->setActions(strtolower($this->table));
        $this->setSearch();
        $this->setCounts($router);
        $this->setModelData($router);
        $this->addDataField('id', $this->nameIdColumn());
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
        $this->setBrowseData($router,  $this->search);
        $router->renderView('/admin/browse', $this->data);
    }

    /**
     * Execute details route
     * @param Router $router
     * @throws Exception
     */
     public function details($router){
         $this->setDetailsData($router);
//         $_POST = json_decode(file_get_contents('php://input'), true);
         if ($_POST) {
            $this->save($router, $_POST);
            $router->redirect($this->actions['browse']);
            return;
        }
        $router->renderView('/admin/details', $this->data);
    }

    /**
     * Save record(s) in db
     * @param Router $router
     * @param array $data - $_POST
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
        $model->save($router);
    }

    /**
     * Execute delete route
     * @param Router $router
     */
    public function delete($router){
        $id = $_POST['id'];
        $router->db->delete($this->table)->where([$this->nameIdColumn(), $id])->execute();
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
     * @param Router $router
     */
    protected function setDetailsData($router){
        if (isset($_GET['id'])) {
            $this->setExistingDetailsData($router);
            $id = $this->data['fields'][$this->nameIdColumn()];
            $this->addIdToActions($id);
        } else {
           $this->setNewDetailsData($router);
        }
    }

    /**
     * Add browse fields to $this->data using $this->addDataField($name, $data)
     * @param Router $router
     * @param array $search
     */
    protected function setBrowseData($router, $search = []){
        $this->addDataField(
            'fields',
            $router->db
                ->select($this->table)
                ->where($search)
                ->fetchAll()
        );
    }

    /**
     * Add details to data for update
     * @param Router $router
     */
    protected function setExistingDetailsData($router){
        $this->addDataField(
            'fields',
            $router->db
                ->select($this->table)
                ->where([$this->nameIdColumn(), $_GET['id']])
                ->fetch()
        );
    }

    /**
     * Add details to data for create
     * @param Router $router
     */
    protected function setNewDetailsData($router){
        $data = $router->db->describe($this->table)->fetchAll();
        $fields = [];
        foreach ($data as $item){
            $fields[$item['Field']] = '';
        }
        $this->addDataField('fields', $fields);
    }

    /**
     * Add key/value pair to data
     * @param string $name - name of field in response
     * @param array $data - associated data (likely db result)
     */
    protected function addDataField($name, $data){
        $this->data[$name] = $data;
    }

    /**
     * Return name of id column for db queries
     */
    protected function nameIdColumn(){
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
     * @param Router $router
     */
    protected function setModelData($router){
        $class = 'app\models\viewmodels\\'.$this->class;
        $viewmodel = new $class($router);
        $model = $viewmodel->getData();
        foreach ($model as $key => $data){
            $this->addDataField($key, $data);
        }
    }

    /**
     * Set counts
     * @param Router $router
     */
    protected function setCounts($router){
        $this->counts = [];
    }

    /**
     * Add key/value pair to counts
     * @param string $name
     * @param string $column
     * @param array $data
     */
    protected function addCount($name, $column, $data){
        $this->counts[$name]['value'] = $data["COUNT(".$column.")"];
    }

}
