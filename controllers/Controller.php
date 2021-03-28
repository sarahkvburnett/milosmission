<?php


namespace app\controllers;


use app\classes\Factory;

class Controller extends Factory {

    protected static string $classname = 'Controller';
    protected static array $sources = ["app\controllers\\", "app\controllers\admin\\"];

}
