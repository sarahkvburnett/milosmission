<?php


namespace app\classes;


use app\classes\Factory;

class Controller extends Factory {

    protected static string $classname = 'Controller';
    protected static array $sources = ["app\controller\\", "app\controller\admin\\"];

}
