<?php


namespace app\controllers\admin;

use app\controllers\abstracts\Admin;
use app\database\Database;
use app\Router;
use http\Exception;

class Animal extends Admin {

    function setClass() {
        $this->class = 'Animal';
    }

    function setTable() {
        $this->table = 'animals';
    }
}
