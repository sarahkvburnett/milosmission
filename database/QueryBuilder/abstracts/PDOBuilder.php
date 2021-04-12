<?php


namespace app\database\QueryBuilder\abstracts;


use app\classes\Database;

class PDOBuilder extends SQLBuilder {

    // Add ':' for bind values

    public function insert($values) {
        $insertSQL = "INSERT INTO $this->table (";
        $valuesSQL = "VALUES (";
        foreach ($values as $key => $value) {
            $insertSQL .= "$key, ";
            $valuesSQL .= ":$key, ";
        }
        $this->query = "$this->trimSql($insertSQL)) $this->trimSql($valuesSQL))";
        $this->values = $values;
        return $this;
    }

    public function update($values) {
        $sql = "UPDATE $this->table SET";
        foreach ($values as $key => $value) {
            if (isset($key)) {
                $sql .= " $key=:$key, ";
            }
        }
        $this->query = $this->trimSql($sql);
        $this->values = $values;
        return $this;
    }

}
