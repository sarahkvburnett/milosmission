<?php


namespace app\database;


class SQL {
    //POSTS
    static public $getPostsWithSearch = 'SELECT * FROM photos WHERE label = :search';
    static public $getPosts =  'SELECT * FROM photos';
    static public $getPostById = 'SELECT * FROM photos WHERE id=:id';
    static public $createPost = 'INSERT INTO photos (label, url, caption) VALUES(:label, :url, :caption)';
    static public $updatePost = 'UPDATE photos SET label=:label, url=:url, caption=:caption) WHERE id=:id';
    static public $deletePostById = 'DELETE FROM photos WHERE id=:id';
    //USERS
    static public $getUserByEmail = 'SELECT * FROM users where email=:email';
    //ANIMALS
    static public function getAnimalsWithSearch($search){
     return 'SELECT * FROM animals WHERE '.$search['column'].'=\''.$search['item'].'\'';
    }
    static public $getAnimals = 'SELECT * FROM animals';
    static public $getAnimalById = 'SELECT * FROM animals WHERE id=:id';
    static public function updateAnimal($animal){
        $sql = "UPDATE animals SET";
        foreach( $animal as $key => $value){
            if (isset($key)) {
                $sql = $sql." ".$key."=:".$key.",";
            }
        }
        $sql = substr($sql, 0, -1)." WHERE id=:id";
        return $sql;
    }
    static public function createAnimal($animal){
        $insertSQL="INSERT INTO animals (";
        $valuesSQL="VALUES(";
        foreach( $animal as $key => $value){
            if (isset($key)) {
                $insertSQL = $insertSQL.$key.", ";
                $valuesSQL = $valuesSQL.":".$key.", ";
            }
        }
        return substr($insertSQL, 0, -2).") ".substr($valuesSQL, 0, -2).")";
    }
    static public $deleteAnimalById = 'DELETE FROM animals WHERE id=:id';
}
