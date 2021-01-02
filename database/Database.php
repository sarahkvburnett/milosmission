<?php

namespace app\database;

use app\database\SQL;
use http\Env;
use \PDO;

class Database {
    public $pdo;
    public static $db;

    public function __construct() {
        $this->pdo = new PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$db = $this;
    }

    //POSTS
    public function getPosts($search = ''){
        if ($search) {
            $statement = $this->pdo->prepare(SQL::$getPostsWithSearch);
            $statement->bindValue(':search', $search);
        }
        else {
            $statement = $this->pdo->prepare(SQL::$getPosts);
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostById($id){
        $statement = $this->pdo->prepare(SQL::$getPostById);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function savePost($product){
            $statement;
           if (isset($product->id)){
               $statement = $this->pdo->prepare(SQL::$updatePost);
               $statement->bindValue(':id', $product->id);
           } else {
               $statement = $this->pdo->prepare(SQL::$createPost);
           }
            $statement->bindValue(':label', $product->label);
            $statement->bindValue(':url', $product->url);
            $statement->bindValue(':caption', $product->caption);
            return $statement->execute();
    }

    public function deletePostById($id){
        $statement = $this->pdo->prepare(SQL::$deletePostById);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
    //USERS
    public function getUserByEmail($user){
        $statement = $this->pdo->prepare(SQL::$getUserByEmail);
        $statement->bindValue(':email', $user->email);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    //ANIMALS
    public function getAnimals($search){
        if (!empty($search['column']) and !empty($search['item'])) {
            $statement = $this->pdo->prepare(SQL::getAnimalsWithSearch($search));
        }
        else {
            $statement = $this->pdo->prepare(SQL::$getAnimals);
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnimalById($id){
        $statement = $this->pdo->prepare(SQL::$getAnimalById);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function saveAnimal($animal){
        $statement;
        if (isset($animal->id)){
            $statement = $this->pdo->prepare(SQL::updateAnimal($animal));
            $statement->bindValue(':id', $animal->id);
        } else {
            $statement = $this->pdo->prepare(SQL::createAnimal($animal));
        }
        foreach( $animal as $key => $value){
            $statement->bindValue(':'.$key, $value);
        }
        return $statement->execute();
    }

    public function deleteAnimalById($id){
        $statement = $this->pdo->prepare(SQL::$deleteAnimalById);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }

}
