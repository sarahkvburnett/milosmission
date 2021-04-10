<?php


namespace app\repository\admin;

use app\database\QueryBuilder\PDO_MYSQL;
use app\repository\abstracts\Repo;

class AdminRepo extends Repo {

    public function setQueryBuilder() {
        return new PDO_MYSQL($this->dbConnections->get('mysql'));
    }

    public function findUserByEmail($email){
        return $this->db->table('users')->select()->where('user_email', $email)->findOne();
    }

}
