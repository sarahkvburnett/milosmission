<?php


namespace app\repository\admin;


use app\database\QueryBuilder\PDO_MYSQL;
use app\repository\abstracts\iRepo;
use app\repository\abstracts\Repo;

class AdminRepo extends Repo implements iRepo {

    public function getQueryBuilder() {
        return new PDO_MYSQL($this->dbConnections->get('mysql'));
    }

}
