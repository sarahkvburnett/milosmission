<?php


namespace app\database\Adaptor;


use app\database\Adaptor\abstracts\iMongo;
use MongoDB\Client;

class Mongo implements iMongo {

    protected $client;

    public function __construct($dbCredentials) {
        $this->client = new Client($dbCredentials['uri']);
    }

    public function findOne($collection, $filter = []) {
        return $this->client->$collection->findOne($filter);
    }

    public function findAll($collection, $filter = []) {
        return $this->client->$collection->findAll($filter);
    }

    public function insertOne($collection, $values = [], $filter = []) {
        return $this->client->$collection->insertOne($filter, $values);
    }

    public function insertMany($collection, $values = [], $filter = []) {
        return $this->client->$collection->insertMany($filter, $values);
    }

    public function updateOne($collection, $values = [], $filter = []) {
        return $this->client->$collection->updateOne($filter, $values);
    }

    public function updateMany($collection, $values = [], $filter = []) {
        return $this->client->$collection->updateMany($filter, $values);
    }

    public function deleteOne($collection, $filter = []) {
        return $this->client->$collection->deleteOne($filter);
    }

    public function deleteMany($collection, $filter = []) {
        return $this->client->$collection->deleteMany($filter);
    }
}
