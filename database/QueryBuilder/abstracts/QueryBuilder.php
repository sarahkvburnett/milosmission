<?php


namespace app\database\QueryBuilder\abstracts;


use app\database\Adaptor\abstracts\iAdaptor;
use app\database\Connection;

abstract class QueryBuilder implements iQueryBuilder {

    protected $db;

    public function __construct($dbConnection){
        $this->db = $dbConnection;
    }

}
