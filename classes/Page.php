<?php


namespace app\classes;


use app\controller\abstracts\iController;
use app\model\abstracts\iModel;
use app\repository\abstracts\iRepo;
use Exception;

class Page {

    protected ?iModel $model;
    protected ?iController $controller;
    protected ?iRepo $repo;

    protected ?int $id = null;
    public bool $hasModel = false;

    public static Page $instance;

    public static function setInstance($page){
        if (!isset(self::$instance)) self::$instance = new Page($page);
        return self::$instance;
    }

    public static function getInstance(){
        return self::$instance;
    }


    public function __construct($page) {
        $this->classname = $page;
        $request = Request::getInstance();
        if ($request->hasId()) $this->id = $request->getId();
    }

    //SETTERS
    public function setController($repo) {
        if (!isset($this->controller)) $this->controller = Controller::factory($this->classname, $repo);
        return $this->controller;
    }

    public function setModel() {
        if (!isset($this->model)) {
            $this->model = Model::factory($this->classname);
            $this->hasModel = true;
        }
        return $this->model;
    }

    public function setRepo() {
        if (!isset($this->repo)) $this->repo = Repository::factory($this->classname."Repo");
        return $this->repo;
    }


    //GETTERS

    public function getController($repo) {
        if (!isset($this->controller)) throw new Exception('Controller not set', 400);
        return $this->controller;
    }

    public function getModel() {
        if (!isset($this->model)) throw new Exception('Model not set', 400);
        return $this->model;
    }

    public function getRepo() {
        if (!isset($this->repo)) throw new Exception('Repository not set', 400);
        return $this->repo;
    }

    public function getTable() {
        if (!isset($this->model)) throw new Exception('No table - Admin not set', 400);
        return $this->model->getTable();
    }

    public function getIdColumn() {
        if (!isset($this->model)) throw new Exception('No id column - Admin not set', 400);
        return $this->model->getIdColumn();
    }

    public function getName() {
        if (!isset($this->model)) throw new Exception('No name - Admin not set', 400);
        return $this->model->getName();
    }

    public function describe(){
        if (!isset($this->repo)) throw new Exception('No description - Repository not set', 400);
        return $this->repo->describe();
    }

}
