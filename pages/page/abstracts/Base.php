<?php


namespace app\pages\page\abstracts;


interface Base {

    public function getController();
    public function getModel();
    public function getRepo();
    public function getTable();
    public function getName();

}
