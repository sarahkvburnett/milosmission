<?php

namespace app\database;

use app\database\Adaptor\interfaces\Adaptor;
use app\database\Adaptor\PDO;
use Exception;
use http\Env;

/**
 * Class Database
 * @package app\database
 * Version 2.0
 */
class Database {

    public static function factory($adaptor, $dbCredentials) {
        $class = 'app\database\Adaptor\\'.$adaptor;
        $db = new $class($dbCredentials);
        if(!$db instanceof Adaptor ){
            throw new Exception("$class is not a db extension");
        }
        return $db;
    }
}

