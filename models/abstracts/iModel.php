<?php


namespace app\models\abstracts;

use app\classes\Page;
use app\database\Database;

interface iModel {

    public function setData();
    public function getData();
    public function getTable();
    public function getIdColumn();
    public function getName();

}
