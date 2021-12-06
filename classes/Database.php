<?php

namespace app\classes;

use app\database\Driver\abstracts\iDriver;
use \Exception;

/**
 * Class Database
 * @package app\database
 * Version 2.0
 */
class Database extends Factory {

    protected static string $classname = 'Driver';
    protected static array $sources = ['app\database\Driver\\'];

}

