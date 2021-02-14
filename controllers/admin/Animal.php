<?php


namespace app\controllers\admin;

use app\controllers\Admin;

class Animal extends Admin {

    protected string $class = 'Animal';
    protected string $table = 'animals';

    public function setExistingDetailsData($router){
        $fields = $router->db
                ->select($this->table)
                ->join('media', 'media_id')
                ->where(['animal_id', $_GET['id']])
                ->fetch();
        $this->addDataField('fields', $fields);
        if (!empty($fields['friend_id'])){
            $friend = $router->db
                    ->select($this->table)
                    ->where(['animal_id', $this->data['fields']['friend_id']])
                    ->fetch();
            $this->addDataField('friend', $friend);
        }
        if (!empty($fields['id'])){
            $media = $router->db
                ->select('animal_media')
                ->join('media', 'media_id')
                ->where(['animal_media_id', $this->data['fields']['animal_id']])
                ->fetchAll();
            $this->addDataField('media', $media);
        }
    }

    public function setBrowseData($router, $search = []){
        $fields = $router->db
                    ->select($this->table)
                    ->join('media', 'media_id')
                    ->where($search)
                    ->fetchAll();
        $this->addDataField('fields', $fields);
        $this->addDataField('counts', $this->fetchCounts($router));
    }

    private function fetchCounts($router){
        $all = $router->db->count('animal_id', $this->table)->fetch();
        $new = $router->db->count('animal_id', $this->table)->where(['animal_status', 'new'])->fetch();
        $waiting = $router->db->count('animal_id', $this->table)->where(['animal_status', 'waiting'])->fetch();
        $rehomed = $router->db->count('animal_id', $this->table)->where(['animal_status', 'rehomed'])->fetch();
        return [
            'all' => $all["COUNT(animal_id)"],
            'new' => $new["COUNT(animal_id)"],
            'waiting' => $waiting["COUNT(animal_id)"],
            'rehomed' => $rehomed["COUNT(animal_id)"]
        ];
    }

}
