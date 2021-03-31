<?php


namespace app\repository;


use app\classes\Factory;

class Repo extends Factory {

    protected static string $classname = 'Repo';
    protected static array $sources = ["app\\repository\\", "app\\repository\\admin\\"];

}
