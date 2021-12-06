<?php


namespace app\database\QueryBuilder;


use app\database\QueryBuilder\abstracts\PDOBuilder;

class PDO_PGSQL extends PDOBuilder {

    public function whereAny($value, $array) {
        $sql = " ";
        if (!$this->hasWhere) {
            $sql .= "WHERE ";
        };
        $sql .= "$value=ANY($array)";
        $this->hasWhere = true;
        return $this;
    }

}
