<?php

namespace app\database;

use app\database\SQL;
use http\Env;
use \PDO;

class Database {
    public $pdo;
    public static $db;
    public $query;

    public function __construct() {
        $this->pdo = new PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$db = $this;
        $this->query = new Query();
    }

    public function executeQuery($query, $fields = []){
        $statement = $this->pdo->prepare($query);
        foreach( $fields as $key => $value){
            $statement->bindValue(':'.$key, $value);
        }
//        $statement->debugDumpParams();
        $statement->execute();
        if (strpos($query, 'INSERT') !== false or strpos($query, 'UPDATE') !== false or strpos($query, 'DELETE') !== false) return;
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function describe($table){
        return $this->executeQuery('DESCRIBE '.$table);
    }

    public function fineOneByEmail($table, $email){
        return $this->executeQuery($this->query->findByEmail($table, $email), ['email' => $email]);
    }

    public function findOneById($table, $id){
       return $this->executeQuery($this->query->findById($table, $id), ['id' => $id]);
    }

    public function findOptions($table, string $columns, ?string $where){
        return $this->executeQuery($this->query->findOptions($table, $columns, $where));
    }

    public function findAll($table, $condition = []){
      return $this->executeQuery($this->query->findAll($table, $condition));
    }

    public function join(array $table1, array $table2){
        return $this->executeQuery($this->query->join($table1, $table2));
    }

    public function save($table, $model){
        if (isset($model['id'])){
            return $this->executeQuery($this->query->update($table, $model), $model);
        } else {
            return $this->executeQuery($this->query->create($table, $model), $model);
        }
    }

    public function deleteOneById($table, $id){
        return $this->executeQuery($this->query->delete($table, $id), ['id' => $id]);
    }

}
