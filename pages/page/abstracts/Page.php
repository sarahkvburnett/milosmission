<?php


namespace app\pages\page\abstracts;


interface Page {

    function setController();
    function setModel();
    function setViewmodel();
    function setRepo();
    function setTable();
    function setName();

}
