<?php


namespace app\controllers\admin;

use app\controllers\abstracts\AdminGroupAnimals;

class Room extends AdminGroupAnimals {

    function setClass() {
        $this->class = "Room";
    }

    function setTable() {
        $this->table = "rooms";
    }

    public function save($router, $data){
        $data['room_id'] = parent::save($router, $data);
        $this->changeAnimals($data, 'room_id');
    }

    public function delete($router) {
        $this->removeAnimals('room_id');
        parent::delete($router);
    }
}
