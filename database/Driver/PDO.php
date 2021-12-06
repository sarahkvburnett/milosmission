<?php


namespace app\database\Driver;


use app\database\Driver\abstracts\iPDODriver;

class PDO implements iPDODriver {

    public $pdo;

    public function __construct($dbCredentials){
        ['DSN' => $DSN, 'User' => $user, 'Password' => $password, 'Options' => $options] = $dbCredentials;
        $this->pdo = new \PDO($DSN, $user, $password, $options);
    }

    public function findOne($query) {
        $statement = $this->pdo->prepare($query);
//        $statement->debugDumpParams();
        $statement->execute();
        return $statement->fetch();
    }

    public function findAll($query) {
        $statement = $this->pdo->prepare($query);
//        $statement->debugDumpParams();
        $statement->execute();
        return $statement->fetchAll();
    }

    public function save($query, $values = []) {
        $statement = $this->pdo->prepare($query);
//        $statement->debugDumpParams();
        if (!empty($values)) {
            foreach ($values as $key => $value) {
                $statement->bindValue(':' . $key, $value);
            }
        }
        $statement->execute();
    }

    //Specific PDO methods
    public function lastInsertId(){
        return $this->pdo->lastInsertId();
    }
}
