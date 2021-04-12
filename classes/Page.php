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

    public static function getInstance(){
        if (!isset(self::$instance)) self::$instance = new Page();
        return self::$instance;
    }

    public function dispatch($route){
        [$class, $method] = $route;
        if (Model::factory($class)) {
            $this->model = Model::factory($class);
            $this->hasModel = true;
        }
        $this->repo = Repository::factory($class."Repo");
        $this->controller = Controller::factory($class, $this->repo);
        $this->controller->$method(Response::getInstance());
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
