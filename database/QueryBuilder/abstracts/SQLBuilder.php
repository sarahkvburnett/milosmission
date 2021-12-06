<?php


namespace app\database\QueryBuilder\abstracts;


use app\classes\Page;

abstract class SQLBuilder extends QueryBuilder {

    protected $query;
    protected $table;
    protected $tempTable;
    protected $values;
    protected $hasWhere = false;

    //Methods to call db driver

    public function findOne() {
        $data = $this->db->findOne($this->query);
        $this->reset();
        return $data;
    }

    public function findAll() {
        $data = $this->db->findAll($this->query);
        $this->reset();
        return $data;
    }

    public function save(){
        $data = $this->db->save($this->query, $this->values);
        $this->reset();
        return $data;
    }

    //Methods to build initial sql statement
    /**
     * Write sql select statement for provided table
     * @param array $columns - provide list of columns else uses '*'
     * @return $this
     */
    public function select($columns = '*'){
        $this->query = "SELECT $columns FROM ".$this->getTable()." t1";
        return $this;
    }

    /**
     * Edit sql statement to add personalised FROM
     * @param $table
     */
    public function from($table){
        $this->query = strtok($this->query,'FROM');
        $this->query .= "FROM $table t1";
        return $this;
    }

    /**
     * Write sql select statement with count function for provided table
     * @param string $id
     * @return $this
     */
    public function count($id) {
        $this->query = "SELECT COUNT($id) FROM ".$this->getTable();
        return $this;
    }

    /**
     * Write sql describe statement for provided table
     * @return $this
     */
    public function describe() {
        $this->query = "DESCRIBE ".$this->getTable();
        return $this;
    }

    /**
     * Write sql insert statement for provided table
     * @param array $values
     * @return $this
     */
    public function insert($values) {
        $insertSQL = "INSERT INTO ".$this->getTable()." (";
        $valuesSQL = "VALUES (";
        foreach ($values as $key => $value) {
            $insertSQL .= "$key, ";
            $valuesSQL .= "$value, ";
        }
        $this->query = "$this->trimSql($insertSQL)) $this->trimSql($valuesSQL))";
        $this->values = $values;
        return $this;
    }

    /**
     * Write sql update statement for provided table
     * @param array $values
     * @return $this
     */
    public function update($values) {
        $sql = "UPDATE ".$this->getTable()." SET";
        foreach ($values as $key => $value) {
            if (isset($key)) {
                $sql .= " $key=$value, ";
            }
        }
        $this->query = $this->trimSql($sql);
        $this->values = $values;
        return $this;
    }

    /**
     * Write sql delete statement for provided table
     * @return $this
     */
    public function delete() {
        $this->query = "DELETE FROM ".$this->getTable();
        return $this;
    }

    /**
     * Generic write sql statement
     * @param string $query
     * @return $this
     */
    public function query($query){
        $this->query = $query;
        return $this;
    }

    // Helper methods to extend sql query - must start with whitespace

    /**
     * Add join to sql statement
     * @param string $type
     * @param string $column
     * @return $this
     */
    public function join($table, $column, $type = 'LEFT') {
        $this->query .= " $type JOIN $table ON t1.$column = $table.$column";
        return $this;
    }

    /**
     * Add where clause to sql statement - can use multiple
     * @param $column - either string for column, or array of [0 => $column, 1 => value];
     * @param null $value - either string for value, or null;
     * @return $this
     */

    public function where($column, $value = null) {
        if (empty($column)) return $this;
        if (is_array($column)){
            $value = $column[1];
            $column = $column[0];
        }
        $sql = " ";
        if (!$this->hasWhere) {
            $sql .= "WHERE ";
        };
        if (is_string($value)){
            $sql .= "$column='$value', ";
        } else {
            $sql .= "$column=$value, ";
        }
        $this->query .= $this->trimSql($sql);
        $this->hasWhere = true;
        return $this;
    }

    //HELPER METHODS

    /**
     * Function to remove trailing comma from sql statement added in final iteration of insert/update
     * @param string $sql
     * @return false|string
     */
    protected function trimSql($sql) {
        return substr($sql, 0, -2);
    }

    /**
     * Set table to query
     * @param $table
     * @return $this
     */
    public function table($table){
        $this->tempTable = $table;
        return $this;
    }

    /**
     * Clean up after query
     * @return $this
     */
    public function reset(){
        $this->tempTable = null;
        $this->hasWhere = false;
        $this->values = null;
        return $this;
    }

    /**
     * Determine whether to use table from setter or from query method
     * @return string
     */
    public function getTable(){
        return isset($this->tempTable) ? $this->tempTable : $this->table;
    }

    public function setTable($table){
        $this->table = $table;
    }


}
