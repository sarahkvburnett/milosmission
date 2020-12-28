<?php

namespace app;

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
            $statement = $this->pdo->prepare('SELECT * FROM photos WHERE label = :search');
            $statement->bindValue(':search', $search);
        }
        else {
            $statement = $this->pdo->prepare('SELECT * FROM photos');
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostById($id){
        $statement = $this->pdo->prepare('SELECT * FROM photos WHERE id=:id');
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function savePost($product){
            $statement;
           if (isset($product->id)){
               $statement = $this->pdo->prepare("UPDATE photos SET label=:label, url=:url, caption=:caption) WHERE id=:id");
               $statement->bindValue(':id', $product->id);
           } else {
               $statement = $this->pdo->prepare("INSERT INTO photos (label, url, caption) VALUES(:label, :url, :caption)");
           }
            $statement->bindValue(':label', $product->label);
            $statement->bindValue(':url', $product->url);
            $statement->bindValue(':caption', $product->caption);
            return $statement->execute();
    }

    public function deletePostById($id){
        $statement = $this->pdo->prepare('DELETE FROM photos WHERE id=:id');
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
    //USERS
    public function getUserByEmail($user){
        $statement = $this->pdo->prepare("SELECT * FROM users where email=:email ");
        $statement->bindValue(':email', $user->email);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
