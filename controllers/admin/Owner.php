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

}
