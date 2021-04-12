<?php


namespace app\controller;

use \app\controller\abstracts\Controller;

class Frontend extends Controller {

    public function index($response){
        $animals = $this->repo->findAnimals();
        $response->send('/index', ['animals' => $animals]);
    }

}
