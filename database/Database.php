<?php

namespace app\database;

use http\Env;
use \PDO;

/**
 * Class Database
 * @package app\database
 * Version 1.2
 */
class Database {
    public $pdo;
    public $statement;
    protected $sql;
    protected $values;
    private bool $hasWhere = false;

    public function __construct($dbCredentials) {
        ['dbDSN' => $DSN, 'dbUser' => $user, 'dbPassword' => $password, 'dbOptions' => $options] = $dbCredentials;
        $this->pdo = new PDO($DSN, $user, $password, $options);
    }

    // Methods to prepare and execute PDO

    /**
     * Function to execute non-fetch queries - insert, update, delete...
     * @return $this
     */
    public function execute() {
        $this->prepareQuery($this->sql)->bindValues($this->values)->executeQuery();
        return $this;
    }

    /**
     * Function to execute fetch one record queries
     * @return array
     */
    public function fetch() {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Function to execute fetch many record queries
     * @return array
     */
    public function fetchAll() {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }


    //Methods to build initial sql statement

    /**
     * Write sql select statement for provided table
     * @param string $table
     * @return $this
     */
    public function select($table, $columns = []) {
        if (empty($columns)){
            $this->sql = 'SELECT * FROM ' . $table . ' t1';
        } else {
            $sql = 'SELECT ';
            foreach ($columns as $column){
                $sql .= $column.', ';
            }
            $this->sql = $this->trimSql($sql).' FROM '.$table . ' t1';
        }
        return $this;
    }

    /**
     * Write sql select statement with count function for provided table
     * @param string $id
     * @param string $table
     * @return $this
     */
    public function count($id, $table) {
        $this->sql = 'SELECT COUNT('.$id.') FROM ' . $table;
        return $this;
    }

    /**
     * Write sql describe statement for provided table
     * @param string $table
     * @return $this
     */
    public function describe($table) {
        $this->sql = 'DESCRIBE ' . $table;
        return $this;
    }

    /**
     * Write sql insert statement for provided table
     * @param string $table
     * @param array $values
     * @return Database $this
     */
    public function insert($table, $values) {
        $this->setValues($values);
        $insertSQL = "INSERT INTO " . $table . " (";
        $valuesSQL = "VALUES (";
        foreach ($values as $key => $value) {
            $insertSQL = $insertSQL . $key . ", ";
            $valuesSQL = $valuesSQL . ":" . $key . ", ";
        }
        $this->sql = $this->trimSql($insertSQL) . ") " . $this->trimSql($valuesSQL) . ")";
        return $this;
    }

    /**
     * Write sql update statement for provided table
     * @param string $table
     * @param array $values
     * @return Database $this
     */
    public function update($table, $values) {
        $this->setValues($values);
        $sql = "UPDATE " . $table . " SET";
        foreach ($values as $key => $value) {
            if (isset($key)) {
                $sql .= " " . $key . "=:" . $key . ", ";
            }
        }
        $this->sql = $this->trimSql($sql);
        return $this;
    }

    /**
     * Write sql delete statement for provided table
     * @param string $table
     * @return Database $this
     */
    public function delete($table) {
        $this->sql = 'DELETE FROM ' . $table;
        return $this;
    }

    /**
     * Generic write sql statement
     * @param string $query
     * @return Database $this
     */
    public function query($query){
        $this->sql = $query;
        return $this;
    }

    // Helper methods to extend sql query - must start with whitespace

    /**
     * Add join to sql statement
     * @param string $type
     * @param string $table
     * @param string $column
     * @return Database $this
     */
    public function join($table, $column, $type = 'LEFT') {
        $this->sql .= ' ' . $type . ' JOIN ' . $table . ' ON t1.' . $column . ' = ' . $table . '.' . $column . ' ';
        return $this;
    }

    /**
     * Add where clause to sql statement - can use multiple
     * @param array $where [0 => $column, 1 => $value]
     * @return Database $this
     */

    public function where($where = []) {
        if (empty($where)) return $this;
        $sql = '';
        if (!$this->hasWhere) {
            $sql .= ' WHERE';
        };
        $sql .= ' ' . $where[0] . ' = \'' . $where[1] . '\', ';
        $this->sql .= $this->trimSql($sql);
        $this->hasWhere = true;
        return $this;
    }

    /**
     * Function to remove trailing comma from sql statement added in final iteration of insert/update
     * @param string $sql
     * @return false|string
     */
    protected function trimSql($sql) {
        return substr($sql, 0, -2);
    }

    /**
     * Set values
     * @param array $values
     */
    protected function setValues($values) {
        $this->values = $values;
    }

    //Methods for PDO stages

    /**
     * Prepares a statement for execution
     * @param string $query
     * @return Database $this
     */
    protected function prepareQuery($query) {
        $this->statement = $this->pdo->prepare($query);
        return $this;
    }

    /**
     * Bind values to parameters for statement
     * @param array $values
     * @return Database $this
     */
    protected function bindValues($values = []) {
        if (!empty($values)) {
            foreach ($values as $key => $value) {
                $this->statement->bindValue(':' . $key, $value);
            }
        }
        return $this;
    }

    /**
     * Executes prepared statement
     * @return bool
     */
    protected function executeQuery() {
//        $this->statement->debugDumpParams();
        $this->hasWhere = false;
        return $this->statement->execute();
    }

}

