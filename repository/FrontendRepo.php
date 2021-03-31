<?php


namespace app\repository;


use app\database\QueryBuilder\abstracts\iQueryBuilder;
use app\database\QueryBuilder\PDO_MYSQL;
use app\repository\abstracts\iFrontendRepo;
use app\repository\abstracts\Repo;

class FrontendRepo extends Repo implements iFrontendRepo {

    protected iQueryBuilder $db;

    public function getQueryBuilder() {
        return new PDO_MYSQL($this->dbConnections->get('mysql'));
    }

    public function findAnimals($condition = null) {
        return $this->db->table('animals')->select('*, media.media_filename as image')->join('media', 'media_id')->where($condition)->findAll();
    }
}
