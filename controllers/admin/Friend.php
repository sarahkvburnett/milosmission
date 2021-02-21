<?php


namespace app\controllers\admin;


use app\Validator;

class Friend {

    protected string $class = 'Animal';
    protected string $table = 'animals';

    /**
     * Save friend
     * @param $router
     */
    public function save($router){
        $class = 'app\models\\'.$this->class;
        $animal1 = $_POST['animal1'];
        $animal2 = $_POST['animal2'];
        $model = new $class($animal1);
        $errors = $model->save($router);
        $model = new $class($animal2);
        $errors = $model->save($router);
        return $router->renderView('/admin/details', $errors);
    }


}
