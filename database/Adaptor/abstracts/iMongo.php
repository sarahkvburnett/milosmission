<?php


namespace app\database\Adaptor\abstracts;


interface iMongo extends iAdaptor {

    public function findOne($collection, $filter = []);
    public function findAll($collection, $filter = []);
    public function insertOne($collection, $values = [], $filter = []);
    public function insertMany($collection, $values = [], $filter = []);
    public function updateOne($collection, $values = [], $filter = []);
    public function updateMany($collection, $values = [], $filter = []);
    public function deleteOne($collection, $filter = []);
    public function deleteMany($collection, $filter = []);

}
