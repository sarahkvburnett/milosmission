<?php


namespace app\classes;

use app\classes\Factory;

class Repository extends Factory {

    protected static string $classname = 'Repo';
    protected static array $sources = ["app\\repository\\", "app\\repository\\admin\\"];

}
