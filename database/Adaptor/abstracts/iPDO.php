<?php


namespace app\database\Adaptor\abstracts;


interface iPDO extends iAdaptor {

    public function findOne($query);
    public function findAll($query);
    public function save($query, $values = []);

}
