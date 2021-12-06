<?php


namespace app\model\abstracts;

interface iModel {

    public function getTable();
    public function getIdColumn();
    public function getName();

    /**
     * Set model data for request
     * @return array
     */
    public function setData();

    /**
     * Extract model data for request
     * @return array
     */
    public function getData();

}
