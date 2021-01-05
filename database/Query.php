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

    static public function find($table, $search){
        if (!empty($search['column']) and !empty($search['item'])) {
            return self::$$table['findAll'].' WHERE ' . $search['column'] . '=\'' . $search['item'] . '\'';
        } else {
            return self::$$table['findAll'];
        }
    }

    static public function describe($table){
        return 'DESCRIBE '.$table;
    }

    static public $animals = [
        'findAll' => 'SELECT id, name, type,  breed, colour, age, status, image_id as image, room_id, friend_id, owner_id, rehoming_id from animals',
        'findOne' => 'SELECT id, name, type, breed, colour, age, status, image_id, room_id, friend_id, owner_id, rehoming_id from animals WHERE id=:id',
        'deleteOne' => 'DELETE FROM animals WHERE id=:id',
        'createOne' => 'INSERT INTO animals(name, type, breed, colour, age, image_id, status, room_id, friend_id, owner_id, rehoming_id) VALUES (:name, :type, :breed, :colour, :age, :image_id, :status, :room_id, :friend_id, :owner_id, :rehoming_id)',
        'updateOne' => 'UPDATE animals SET name=:name, type=:type, breed=:breed, colour=:colour, age=:age, image_id=:image_id,status=:status, room_id=:room_id, friend_id=:friend_id, owner_id=:owner_id, rehoming_id=:rehoming_id WHERE id=:id'
    ];

    static public $users = [
        'findAll' => 'SELECT id, firstname, lastname, email FROM users',
        'findOne' => 'SELECT * FROM users WHERE id=:id',
        'findOneByEmail'  => 'SELECT * FROM users where email=:email',
        'deleteOne' => 'DELETE FROM users WHERE id=:id',
        'createOne' => 'INSERT INTO users(firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)',
        'updateOne' => 'UPDATE users SET firstname=:firstname,lastname=:lastname,email=:email,password=:password WHERE id=:id'
    ];

    static public $owners = [
        'findAll' => 'SELECT * FROM owners',
        'findOne' => 'SELECT * FROM owners WHERE id=:id',
        'deleteOne' => 'DELETE FROM owners WHERE id=:id',
        'createOne' => 'INSERT INTO owners(firstname, lastname, address, postcode, animal, status) VALUES (:firstname, :lastname, :address, :postcode, :animal, :status)',
        'updateOne' => 'UPDATE owners SET firstname=:firstname,lastname=:lastname,address=:address,postcode=:postcode,animal=:status,status=:status WHERE id=:id'
    ];

    static public $media = [
        'findAll' => 'SELECT * FROM media',
        'findOne' => 'SELECT * FROM media WHERE id=:id',
        'deleteOne' => 'DELETE FROM media WHERE id=:id',
        'createOne' => 'INSERT INTO media(filename, type, category, subcategory) VALUES (:filename, :type, :category, :subcategory)',
        'updateOne' => 'UPDATE media SET filename=:filename, type=:type, category=:category, subcategory=:subcategory WHERE id=:id'
    ];

    static public $rooms = [
        'findAll' => 'SELECT * FROM rooms',
        'findOne' => 'SELECT * FROM rooms WHERE id=:id',
        'deleteOne' => 'DELETE FROM rooms WHERE id=:id',
        'createOne' => 'INSERT INTO rooms(type, occupied) VALUES (:type, :occupied)',
        'updateOne' => 'UPDATE rooms SET type=:type, occupied=:occupied WHERE id=:id'
    ];
}
