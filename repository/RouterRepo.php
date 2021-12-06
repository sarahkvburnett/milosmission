<?php


namespace app\repository;


use app\repository\abstracts\Repo;

class RouterRepo extends Repo {

    public function __construct() {
        $this->init('PDO_PGSQL', 'pgsql');
        $this->setTable('milosmission.routes');
    }

    public function findRoute($url) {
        $route = $this->db->select()->where('url', $url)->findOne();
        if (empty($route)) $route = $this->db->select()->whereAny('aliases', $url)->findOne();
        return $route;
    }

}
