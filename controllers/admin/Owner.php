<?php


namespace app\controllers\admin;

use app\controllers\abstracts\AdminGroupAnimals;

class Owner extends AdminGroupAnimals {

    function setClass() {
        $this->class = 'Owner';
    }

    function setTable() {
        $this->table = "owners";
    }

    public function save($router, $data){
        $data['owner_id'] = parent::save($router, $data);
        $this->changeAnimals($router, $data, 'owner_id');
    }

    public function delete($router) {
        $this->removeAnimals($router, 'owner_id');
        parent::delete($router);
    }

}
