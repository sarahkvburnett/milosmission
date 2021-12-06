<?php


namespace app\repository\admin;

use app\database\QueryBuilder\PDO_MYSQL;
use app\repository\abstracts\Repo;

class AuthRepo extends Repo {

    public function findUserByEmail($email){
        return $this->db->table('users')->select()->where('user_email', $email)->findOne();
    }

}
