<?php


namespace app\controller\admin;


use app\controller\abstracts\Controller;

class Home extends Controller {

    public function index($response){
        $this->menu = $this->repo->findMenu('adminMain');
        $this->cards = $this->repo->findMenu('adminDashboard');
        $response->send('/admin/index', $this->getData());
    }

}
