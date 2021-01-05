<?php

namespace app\database;

use app\database\SQL;
use http\Env;
use \PDO;

class Database {
    public $pdo;
    public static $db;

    public function __construct() {
        $this->pdo = new PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$db = $this;
    }

    public function fineOneByEmail($table, $email){
        $statement = $this->pdo->prepare(Query::$$table['findOneByEmail']);
        $statement->bindValue(':email', $email);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function findOneById($table, $id){
        $statement = $this->pdo->prepare(Query::$$table['findOne']);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll($table, $search = [], $query = null){
        $statement;
        if (isset($query)) {
            $statement = $this->pdo->prepare($query);
        } else {
            $statement = $this->pdo->prepare(Query::find($table, $search));
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save($table, $model){
        $statement;
        if (isset($model->id)){
            $statement = $this->pdo->prepare(Query::$$table['updateOne']);
            $statement->bindValue(':id', $model->id);
        } else {
            $statement = $this->pdo->prepare(Query::$$table['createOne']);
        }
        foreach( $model as $key => $value){
            if ($key !== 'id'){
                $statement->bindValue(':'.$key, $value);
            }
        }
//        $statement->debugDumpParams();
        return $statement->execute();
    }

    public function deleteOneById($table, $id){
        $statement = $this->pdo->prepare(Query::$$table['deleteOne']);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }

}
