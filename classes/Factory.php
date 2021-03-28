<?php


namespace app\classes;


use Exception;

class Factory {

    protected static string $classname;
    protected static array $sources;

    public static function factory($class, $params = null){
        foreach (static::$sources as $source) {
            var_dump($source.$class);
            if (class_exists($source . $class)) {
                $class = $source.$class;
                return new $class($params);
            }
        }
        throw new Exception(static::$classname." Not Found", 404);
    }

}
