<?php


namespace app\repository\abstracts;


use app\database\Connections;
use app\database\QueryBuilder\abstracts\iQueryBuilder;
use app\repository\abstracts\iRepo;

abstract class Repo implements iRepo {

    protected iQueryBuilder $db;
    protected Connections $dbConnections;

    public function __construct(){
        $dbConnections = Connections::getInstance();
        $this->dbConnections = $dbConnections;
        $queryBuilder = $this->getQueryBuilder();
        $this->setQueryBuilder($queryBuilder);
    }

    public function setQueryBuilder($queryBuilder){
        $this->db = $queryBuilder;
    }

}
