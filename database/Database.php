<?php

namespace app\database;

use app\database\Extension\Interfaces\Extension;
use Exception;
use http\Env;
use app\database\Extension\PDO;

/**
 * Class Database
 * @package app\database
 * Version 2.0
 */
class Database {

    public static function factory($extension, $dbCredentials) {
        $class = 'app\database\Extension\\'.$extension;
        $db = new $class($dbCredentials);
        if(!$db instanceof Extension ){
            throw new Exception("$class is not a db extension");
        }
        return $db;
    }
}

