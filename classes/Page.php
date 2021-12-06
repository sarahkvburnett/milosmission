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
        if (!isset(self::$instance)) self::$instance = new self;
        return self::$instance;
    }

    public function dispatch($route){
        $model = $route->model;
        $controller = $route->controller;
        $repo = $route->repo;
        $event = $route->event;
        if (!empty($model)) {
            $this->model = Model::factory($model);
            $this->hasModel = true;
        }
        $this->repo = Repository::factory($repo);
        $this->controller = Controller::factory($controller, $this->repo);
        $this->controller->$event(Response::getInstance());
    }

    public function getModel() {
        return $this->hasModel ? $this->model : null;
    }

    public function getRepo() {
        return $this->repo;
    }

}
