<?php

namespace app\database\QueryBuilder\abstracts;

use app\classes\Page;

abstract class MongoBuilder extends QueryBuilder {

    protected $collection;
    protected $filter;
    protected $values;

    //Methods to prepare params
    public function collection($collection){
        $this->collection = $collection;
    }

    public function filter($filter){
        $this->filter = $filter;
    }

    public function values($values){
        $this->values = $values;
    }

    //Methods to call db driver
    public function findOne() {
        return $this->db->findOne($this->collection, $this->filter);
    }

    public function findAll() {
        return $this->db->findAll($this->collection, $this->filter);
    }

    public function insertMany(){
        return $this->db->insertMany($this->collection, $this->values, $this->filter);
    }

    public function updateOne(){
        return $this->db->updateOne($this->collection, $this->values, $this->filter);
    }

    public function updateMany(){
        return $this->db->updateMany($this->collection, $this->values, $this->filter);
    }

    public function deleteOne(){
        return $this->db->deleteOne($this->collection, $this->filter);
    }

    public function deleteMany(){
       return $this->db->deleteMany($this->collection, $this->filter);
    }

}
