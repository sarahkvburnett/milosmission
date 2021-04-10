<?php


namespace app\controller;

use \app\controller\abstracts\Controller;

class Frontend extends Controller {

    public function index($router){
        $animals = $this->repo->findAnimals();
        $router->sendResponse('/index', ['animals' => $animals]);
    }

}
