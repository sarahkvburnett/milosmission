<?php


namespace app\repository;


use app\database\Database;
use app\repository\Interfaces\Repository;

class AnimalRepo implements Repository {

    protected $db;

    public function __construct($dbConnections){
        $this->db = $dbConnections['mysql'];
        $this->db->setTable('animals');
    }

    public function findOne($id){
         $data = $this->db->select()->join('media', 'media_id')->where('animal_id', $id)->findOne();

         if (!empty($data['friend_id'])){
             $data['friend'] = $this->db->select()->where(['animal_id', $id])->findOne();
         }

         $data['media'] = $this->db->select('*', 'animal_media')->join('media', 'media_id')->where('animal_id', $id)->findAll();

         return $data;
    }

    public function findAll($condition = []){
        return $this->db->select('*, media.media_filename as image')->join('media', 'media_id')->where($condition)->findAll();
    }

    public function update($id, $model){
       $animalId = $model['animal_id'];
       $friendId = $model['friend_id'];

       $this->db->update($model)->where('animal_id', $id, 'LIKE')->save();

        $this->db->update(['friend_id' => NULL])->where('friend_id', $friendId);
        $this->db->update(['friend_id' => NULL])->where('friend_id', $animalId);
        $this->db->update(['friend_id' => $animalId])->where('friend_id', $friendId);
        $this->db->update(['friend_id' => $friendId])->where('friend_id', $animalId);
    }


    public function delete($id) {
        $this->db->update(['friend_id' => NULL])->where('friend_id', $id);
        $this->db->delete()->where('animal_id', $id)->save();
    }

    public function create($model) {
        return $this->db->insert($model)->save();
    }

    public function describe() {
        $data = $this->db->describe()->findAll();
        $fields = [];
        foreach ($data as $item){
            $fields[$item['Field']] = '';
        }
        return $fields;
    }

    public function count($where){
        $data = $this->db->count('animal_id')->where($where);
        return $data["COUNT('animal_id')"];
    }

    public function option($table, $where){
        return $this->db->select()->from($table)->where($where)->findAll();
    }

}
