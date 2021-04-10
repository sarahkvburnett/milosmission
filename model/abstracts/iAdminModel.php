<?php


namespace app\model\abstracts;


interface iAdminModel extends iModel {

    public function getTable();
    public function getIdColumn();
    public function getName();

}
