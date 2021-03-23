<?php


namespace app\database\QueryBuilder;


use app\database\Database;

class SQLBuilder {

    protected $sql;
    protected $values;
    protected bool $hasWhere = false;

    protected $table;

    public function setTable($table){
        $this->table = $table;
    }

    protected function reset(){
        $this->hasWhere = false;
    }

    //Methods to build initial sql statement

    /**
     * Write sql select statement for provided table
     * @param array $columns - provide list of columns else uses '*'
     * @return $this
     */
    public function select($columns = '*'){
        $this->sql = "SELECT $columns FROM $this->table t1";
        return $this;
    }

    /**
     * Edit sql statement to add personalised FROM
     * @param $table
     */
    public function from($table){
        $this->sql = strtok($this->sql,'FROM');
        $this->sql .= "FROM $table t1";
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
            $insertSQL .= $key . ", ";
            $valuesSQL .= $this->addValue($key) . ", ";
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
                $sql .= " " . $key . "=" . $this->addValue($key) . ", ";
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
     * @param $column - either string for column, or array of [0 => $column, 1 => value];
     * @param null $value - either string for value, or null;
     * @return SQLBuilder
     */

    public function where($column, $value = null): SQLBuilder {
        if (empty($column)) return $this;
        if (is_array($column)){
            $value = $column[1];
            $column = $column[0];
        }
        $sql = '';
        if (!$this->hasWhere) {
            $sql .= ' WHERE';
        };
        $sql .= ' ' . $column . ' = \'' . $value . '\', ';
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

    protected function addValue($key){
        return $this->isPDO ? ':'.$key : $key;
    }

}
