<?php


namespace app\classes;


use app\controllers\Controller;
use app\models\Model;
use app\repository\Repo;
use Exception;

class Page {

    protected string $classname;
    protected ?int $id = null;

    public static $instance;

    public static function setInstance($page){
        if (!isset($instance)) self::$instance = new Page($page);
        return self::$instance;
    }

    public static function getInstance(){
        return self::$instance;
    }


    public function __construct($page) {
        $this->classname = $page;
        $request = Request::getInstance();
        if ($request->hasId()) $this->id = $request->getId();
        $this->setActions();
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
        if (!isset($this->repo)) throw new Exception('Repo not set', 400);
        return $this->repo;
    }

    public function getTable() {
        if (!isset($this->model)) throw new Exception('No table - Model not set', 400);
        return $this->model->getTable();
    }

    public function getIdColumn() {
        if (!isset($this->model)) throw new Exception('No id column - Model not set', 400);
        return $this->model->getIdColumn();
    }

    public function getName() {
        if (!isset($this->model)) throw new Exception('No name - Model not set', 400);
        return $this->model->getName();
    }

    public function getActions(){
        $id = $this->id;
        $urls['details'] = isset($id) ? "$this->detailsUrl?id=$id" : $this->detailsUrl;
        $urls['browse'] = $this->browseUrl;
        $urls['delete'] = isset($id) ? "$this->deleteUrl?id=$id" : $this->deleteUrl;
        return $urls;
    }

    //SETTERS
    public function setController($repo) {
        if (!isset($this->controller)) $this->controller = Controller::factory($this->classname, $repo);
        return $this->controller;
    }

    public function setModel() {
        if (!isset($this->model)) $this->model = Model::factory($this->classname);
        return $this->model;
    }

    public function setRepo($dbConnections) {
        if (!isset($this->repo)) $this->repo = Repo::factory($this->classname."Repo", $dbConnections);
        return $this->repo;
    }

    public function setActions(){
        $name = strtolower($this->classname);
        $this->browseUrl = '/admin/'.$name;
        $this->detailsUrl = '/admin/'.$name.'/details';
        $this->deleteUrl = '/admin/'.$name.'/delete';
    }

}
