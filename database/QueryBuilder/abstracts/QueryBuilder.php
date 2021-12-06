<?php


namespace app\database\QueryBuilder\abstracts;


use app\database\Driver\abstracts\iDriver;
use app\database\Connections;

abstract class QueryBuilder implements iQueryBuilder {

    protected $db;

    public function __construct($db){
        $connection = Connections::getInstance();
        $this->db = $connection->get($db);
    }

}
