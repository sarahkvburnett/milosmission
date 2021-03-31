<?php


namespace app\classes;


use Exception;

abstract class Factory {

    protected static string $classname;
    protected static array $sources;

    public static function factory($class, $params = null){
        foreach (static::$sources as $source) {
            if (class_exists($source . $class)) {
                $class = $source.$class;
                return new $class($params);
            }
        }
        throw new Exception(static::$classname." Not Found", 404);
    }

}
