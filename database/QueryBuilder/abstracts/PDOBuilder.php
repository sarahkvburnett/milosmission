<?php


namespace app\database\QueryBuilder\abstracts;


use app\database\Database;

class PDOBuilder extends SQLBuilder {

    // Add ':' for bind values

    public function insert($values) {
        $this->setValues($values);
        $insertSQL = "INSERT INTO $this->table (";
        $valuesSQL = "VALUES (";
        foreach ($values as $key => $value) {
            $insertSQL .= "$key, ";
            $valuesSQL .= ":$value, ";
        }
        $this->sql = "$this->trimSql($insertSQL)) $this->trimSql($valuesSQL))";
        return $this;
    }

    public function update($values) {
        $this->setValues($values);
        $sql = "UPDATE $this->table SET";
        foreach ($values as $key => $value) {
            if (isset($key)) {
                $sql .= " $key = :$value, ";
            }
        }
        $this->sql = $this->trimSql($sql);
        return $this;
    }

}
