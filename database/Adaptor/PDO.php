<?php


namespace app\database\Adaptor;


use app\database\Adaptor\abstracts\iAdaptor;

class PDO implements iAdaptor {

    public $pdo;

    public function __construct($dbCredentials){
        ['DSN' => $DSN, 'User' => $user, 'Password' => $password, 'Options' => $options] = $dbCredentials;
        $this->pdo = new \PDO($DSN, $user, $password, $options);
    }

    public function findOne($query) {
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return $statement->fetch();
    }

    public function findAll($query) {
        $statement = $this->pdo->prepare($query);
        $statement->debugDumpParams();
        $statement->execute();
        return $statement->fetchAll();
    }

    public function save($query) {
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

    //Specific PDO methods

    public function query($sql){
        $this->sql = $sql;
    }

    public function lastInsertId(){
        return $this->pdo->lastInsertId();
    }

}
