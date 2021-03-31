<?php


namespace app\controllers\admin;


use app\classes\Router;
use app\controllers\abstracts\iController;

class Admin implements iController {

    /**
     * Dashboard page
     * @param Router $router
     */
    public function admin($router){
        $router->renderView('/admin/index');
    }

}
