<?php


namespace app\repository;


use app\repository\abstracts\SQLRepo;

class AnimalRepo extends SQLRepo {

    public function findOne($id){
         $data = $this->db->select()->join('media', 'media_id')->where('animal_id', $id)->findOne();

         if (!empty($data['friend_id'])){
             $data['friend'] = $this->db->select()->where(['animal_id', $id])->findOne();
         }

         $data['media'] = $this->db->select()->from('animal_media')->join('media', 'media_id')->where('animal_id', $id)->findAll();

         return $data;
    }

    public function findAll($condition = []){
        return $this->db->select('*, media.media_filename as image')->join('media', 'media_id')->where($condition)->findAll();
    }

    public function create($model){
        //todo
    }

    public function update($id, $model){
       $animalId = $model['animal_id'];
       $friendId = $model['friend_id'];

       $this->db->update($model)->where('animal_id', $id, 'LIKE')->save();

        $this->db->update(['friend_id' => NULL])->where('friend_id', $friendId);
        $this->db->update(['friend_id' => NULL])->where('friend_id', $animalId);
        $this->db->update(['friend_id' => $animalId])->where('friend_id', $friendId);
        $this->db->update(['friend_id' => $friendId])->where('friend_id', $animalId);

        return $id;
    }


    public function delete($id) {
        $this->db->update(['friend_id' => NULL])->where('friend_id', $id);
        $this->db->delete()->where('animal_id', $id)->save();
    }


}
