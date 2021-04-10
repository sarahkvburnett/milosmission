<?php


namespace app\database\QueryBuilder\abstracts;


use app\classes\Page;

class SQLBuilder extends QueryBuilder {

    protected ?string $query;
    protected ?string $table;
    protected ?array $values;
    protected bool $hasWhere = false;

    //Methods to build initial sql statement

    /**
     * Write sql select statement for provided table
     * @param array $columns - provide list of columns else uses '*'
     * @return $this
     */
    public function select($columns = '*'){
        $this->query = "SELECT $columns FROM $this->table t1";
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
        $this->query = "SELECT COUNT($id) FROM $this->table";
        return $this;
    }

    /**
     * Write sql describe statement for provided table
     * @return $this
     */
    public function describe() {
        $this->query = "DESCRIBE $this->table";
        return $this;
    }

    /**
     * Write sql insert statement for provided table
     * @param array $values
     * @return $this
     */
    public function insert($values) {
        $insertSQL = "INSERT INTO $this->table (";
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
        $sql = "UPDATE $this->table SET";
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
        $this->query = "DELETE FROM $this->table";
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
        $this->table = $table;
        return $this;
    }

    /**
     * Clean up after query
     */
    public function reset(){
        $page = Page::getInstance();
        if ($page->hasModel){
            $this->table = $page->getTable();
        }
        $this->hasWhere = false;
        $this->values = null;
        return $this;
    }


}
