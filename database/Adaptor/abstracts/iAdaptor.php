<?php


namespace app\database\Adaptor\abstracts;


interface iAdaptor {

    public function findOne($query);
    public function findAll($query);
    public function save($query);
//    public function delete();

}
