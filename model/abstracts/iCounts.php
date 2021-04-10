<?php


namespace app\model\abstracts;


interface iCounts {

    public function setCounts();

    public function addSearchCount($name, $column, $value);

    public function addCount($name, $url);

}
