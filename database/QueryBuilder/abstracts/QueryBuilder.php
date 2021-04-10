<?php


namespace app\database\QueryBuilder\abstracts;


use app\database\Adaptor\abstracts\iAdaptor;
use app\database\Connection;

abstract class QueryBuilder implements iQueryBuilder {

    protected ?string $query;
    protected iAdaptor $db;

    public function __construct($dbConnection){
        $this->db = $dbConnection;
    }

    //Methods to execute sql statement
    public function findOne() {
        $data = $this->db->findOne($this->query);
        $this->reset();
        return $data;
    }

    public function findAll() {
        $data = $this->db->findAll($this->query);
        $this->reset();
        return $data;
    }

    public function save() {
        $data = $this->db->save($this->query, $this->values);
        $this->reset();
        return $data;
    }

    //Clean up
    abstract public function reset();

}
