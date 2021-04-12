<?php

namespace app\database\QueryBuilder\abstracts;

use app\classes\Page;

class MongoBuilder extends QueryBuilder {

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
        $data = $this->db->findOne($this->collection, $this->filter);
        $this->reset();
        return $data;
    }

    public function findAll() {
        $data = $this->db->findAll($this->collection, $this->filter);
        $this->reset();
        return $data;
    }


    public function insertMany(){
        $data = $this->db->insertMany($this->collection, $this->values, $this->filter);
        $this->reset();
        return $data;
    }

    public function updateOne(){
        $data = $this->db->updateOne($this->collection, $this->values, $this->filter);
        $this->reset();
        return $data;
    }

    public function updateMany(){
        $data = $this->db->updateMany($this->collection, $this->values, $this->filter);
        $this->reset();
        return $data;
    }

    public function deleteOne(){
        $data = $this->db->deleteOne($this->collection, $this->filter);
        $this->reset();
        return $data;
    }

    public function deleteMany(){
        $data = $this->db->deleteMany($this->collection, $this->filter);
        $this->reset();
        return $data;
    }


    public function reset() {
        $page = Page::getInstance();
        if ($page->hasModel){
            $this->collection = $page->getTable();
        }
    }
}
