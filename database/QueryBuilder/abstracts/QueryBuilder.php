<?php


namespace app\database\QueryBuilder\abstracts;


use app\database\Adaptor\abstracts\iAdaptor;

abstract class QueryBuilder {

    protected ?string $query;
    protected iAdaptor $db;

    public function __construct($dbConnection){
        $this->db = $dbConnection;
    }

    //Methods to execute sql statement
    public function findOne() {
        $this->reset();
        return $this->db->findOne($this->query);
    }

    public function findAll() {
        $this->reset();
        return $this->db->findAll($this->query);
    }

    public function save() {
        $this->reset();
        return $this->db->save($this->query);
    }

    //Clean up
    abstract public function reset();

}
