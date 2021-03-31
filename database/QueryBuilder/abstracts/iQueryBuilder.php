<?php


namespace app\database\QueryBuilder\abstracts;


interface iQueryBuilder {

    public function findOne();
    public function findAll();
    public function save();

    public function reset();

}
