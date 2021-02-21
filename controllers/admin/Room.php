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

    //todo add in occupant(s) of room
}
