<?php


namespace app\database;


class Query {
    static public function update($table, $model){
        $sql = "UPDATE ".$table." SET";
        foreach( $model as $key => $value){
            if (isset($key)) {
                $sql = $sql." ".$key."=:".$key.",";
            }
        }
        $sql = substr($sql, 0, -1)." WHERE id=:id";
        return $sql;
    }

    static public function create($table, $model){
        $insertSQL="INSERT INTO ".$table." (";
        $valuesSQL="VALUES(";
        foreach( $model as $key => $value){
            if (isset($key)) {
                $insertSQL = $insertSQL.$key.", ";
                $valuesSQL = $valuesSQL.":".$key.", ";
            }
        }
        return substr($insertSQL, 0, -2).") ".substr($valuesSQL, 0, -2).")";
    }

    static public function findWithSearch($table, $search){
            return 'SELECT * FROM '.$table.' WHERE '.$search['column'].'=\''.$search['item'].'\'';
    }

    static public $animals = [
        'findAll' => 'SELECT * FROM animals',
        'findOne' => 'SELECT * FROM animals WHERE id=:id',
        'deleteOne' => 'DELETE FROM animals WHERE id=:id',
        'createOne' => 'INSERT INTO animals(name, type, breed, colour, age, image, status, room_id, friend_id, owner_id, rehoming_id) VALUES (:name, :type, :breed, :colour, :age, :image, :status, :room_id, :friend_id, :owner_id, :rehoming_id)',
        'updateOne' => 'UPDATE animals SET name=:name, type=:type, breed=:breed, colour=:colour, age=:age, image=:image,status=:status, room_id=:room_id, friend_id=:friend_id, owner_id=:owner_id, rehoming_id=:rehoming_id WHERE id=:id'
    ];

    static public $users = [
        'findAll' => 'SELECT id, firstname, lastname, email FROM users',
        'findOne' => 'SELECT * FROM users WHERE id=:id',
        'deleteOne' => 'DELETE FROM users WHERE id=:id',
        'createOne' => 'INSERT INTO users(firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)',
        'updateOne' => 'UPDATE users SET firstname=:firstname,lastname=:lastname,email=:email,password=:password WHERE id=:id'
    ];

    static public $owners = [
        'findAll' => 'SELECT * FROM owners',
        'findOne' => 'SELECT * FROM owners WHERE id=:id',
        'deleteOne' => 'DELETE FROM owners WHERE id=:id',
        'createOne' => 'INSERT INTO owners(firstname, lastname, address, postcode, animal, status, new) VALUES (:id, :firstname, :lastname, :address, :postcode, :animal, :status, :new)',
        'updateOne' => 'UPDATE owners SET firstname=:firstname,lastname=:lastname,address=:address,postcode=:postcode,animal=:status,status=:status,new=:new WHERE id=:id'
    ];

    static public $media = [
        'findAll' => 'SELECT * FROM media',
        'findOne' => 'SELECT * FROM media WHERE id=:id',
        'deleteOne' => 'DELETE FROM media WHERE id=:id',
        'createOne' => 'INSERT INTO media(id, filename, type) VALUES (:id, :filename, :type)',
        'updateOne' => 'UPDATE media SET id=:id,filename=:filename,type=:type WHERE id=:id'
    ];


}
