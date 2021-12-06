<?php


namespace app\database\Driver\abstracts;


interface iPDODriver extends iDriver {

    public function findOne($query);
    public function findAll($query);
    public function save($query, $values = []);

}
