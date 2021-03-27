<?php


namespace app\pages\page\abstracts;


abstract class Admin implements Base, Page {

    protected $controller;
    protected $model;
    protected $viewmodel;
    protected $repo;
    protected $table;
    protected $idColumn;
    protected $name;

    protected $detailsUrl;
    protected $browseUrl;
    protected $deleteUrl;

    public function __construct() {
        $this->setController();
        $this->setModel();
        $this->setViewmodel();
        $this->setRepo();
        $this->setTable();
        $this->setName();
    }

    public function getController() {
        $class = $this->controller;
        $sources = ['app\\controllers\\', 'app\controllers\admin\\'];
        foreach ($sources as $source) {
            if (class_exists($source . $class)) {
                return $source . $class;
            }
        }
        throw new Exception('Controller Not Found', 404);
    }

    public function getModel() {
        return "app\\models\\$this->model";
    }

    public function getRepo() {
        return "app\\repository\\$this->repo";
    }

    public function getTable() {
        return $this->table;
    }

    public function getName() {
        return $this->name;
    }

    public function getActions($route, $id = null){
        $urls['details'] = isset($id) ? "$this->detailsUrl?id=$id" : $this->detailsUrl;
        $urls['browse'] = $this->browseUrl;
        $urls['delete'] = isset($id) ? "$this->deleteUrl?id=$id" : $this->deleteUrl;
        return $urls;
    }

}
