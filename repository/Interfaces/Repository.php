<?php


namespace app\repository\Interfaces;


interface Repository {

    public function findAll($condition);
    public function findOne($id);
    public function create($model);
    public function update($id, $model);
    public function delete($id);
    public function describe();

////diff interface:
//    public function *count();
//public function *options();
}
