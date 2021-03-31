<?php


namespace app\repository\abstracts;


interface iAdminRepo extends iRepo {

    public function findAll($condition);
    public function findOne($id);
    public function create($model);
    public function update($id, $model);
    public function delete($id);
    public function describe();
    public function count($condition);

}
