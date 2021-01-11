<?php


namespace app\database;


class Query {

    public function findAll(string $table, ?array $condition){
        $sql = 'SELECT * FROM '.$table;
        if (!empty($condition['field']) and !empty($condition['value'])){
            $sql = $sql . ' WHERE ' . $condition['field'] . '=\'' . $condition['value'] . '\'';
        }
        return $sql;
    }

    public function findOptions(string $table, string $column, ?string $where = null){
        $query = 'SELECT '.$column.' FROM '.$table;
        if (!isset($where)){
            $query .= " ".$where;
        }
        return $query;
    }

    public function findById($table, $id){
        return $this->findAll($table, ['field'=>'id', 'value'=>$id]);
    }

    public function findByEmail($table, $email){
        return $this->findAll($table, ['field'=>'email', 'value'=>$email]);
    }

    public function join(array $table1, array $table2, $condition = null){
        $sql = 'SELECT ';
        foreach ($table1['fields'] as $field){
            $sql .= 't1.'.$field.', ';
        }
        foreach ($table2['fields'] as $field){
            $sql .= 't2.'.$field.', ';
        }
        $sql = substr($sql, 0, -1);
        $sql .= 'FROM '.$table1['name'].' t1 LEFT JOIN on '.$table2['name'].' t2';
        if (isset($condition)) {
            $sql .= $condition;
        }
        return $sql;
    }

    public function create($table, $model){
        $insertSQL="INSERT INTO ".$table." (";
        $valuesSQL="VALUES(";
        foreach( $model as $key => $value){
            $insertSQL = $insertSQL.$key.", ";
            $valuesSQL = $valuesSQL.":".$key.", ";
        }
        return substr($insertSQL, 0, -2).") ".substr($valuesSQL, 0, -2).")";
    }

    public function update($table, $model){
        $sql = "UPDATE ".$table." SET";
        foreach( $model as $key => $value){
            if (isset($key)) {
                $sql .= " ".$key."=:".$key.",";
            }
        }
        $sql = substr($sql, 0, -1)." WHERE id=:id";
        return $sql;
    }

    public function delete($table){
        return 'DELETE FROM '.$table.' WHERE id=:id';
    }
}
