<?php


namespace app\model\abstracts;

interface iModel {

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
