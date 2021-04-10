<?php


namespace app\repository\abstracts;


use app\database\Connection;
use app\database\QueryBuilder\abstracts\iQueryBuilder;

abstract class Repo implements iRepo {

    protected iQueryBuilder $db;
    protected Connection $dbConnections;

    public function __construct(){
        $this->dbConnections = Connection::getInstance();
        $this->db = $this->setQueryBuilder();
    }

}
