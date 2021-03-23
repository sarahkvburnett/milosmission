<?php


namespace app\database\Extension;

use app\database\Extension\Interfaces\Extension;
use app\database\QueryBuilder\SQLBuilder;

class PDO extends SQLBuilder implements Extension {

    public $pdo;
    public $sql;

    public function __construct($dbCredentials){
        ['dbDSN' => $DSN, 'dbUser' => $user, 'dbPassword' => $password, 'dbOptions' => $options] = $dbCredentials;
        $this->pdo = new \PDO($DSN, $user, $password, $options);
    }

    public function findOne() {
        $this->reset();
        $statement = $this->pdo->prepare($this->sql);
        $statement->execute();
        return $statement->fetch();
    }

    public function findAll() {
        $this->reset();
        $statement = $this->pdo->prepare($this->sql);
        $statement->debugDumpParams();
        $statement->execute();
        return $statement->fetchAll();
    }

    public function save() {
        $statement = $this->pdo->prepare($this->sql);
        $statement->execute();
    }

    public function query($sql){
        $this->sql = $sql;
    }


}
