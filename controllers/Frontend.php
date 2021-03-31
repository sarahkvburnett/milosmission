<?php


namespace app\controllers;


use app\classes\Page;
use app\classes\Request;
use app\controllers\abstracts\iController;
use app\database\Database;

class Frontend implements iController {

    protected $repo;

    public function __construct($repo){
        $this->repo = $repo;
    }

    public function index($router){
        $animals = $this->repo->findAnimals();
        $router->renderView('/index', ['animals' => $animals]);
    }

}
