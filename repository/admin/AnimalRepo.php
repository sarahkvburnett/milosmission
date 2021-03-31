<?php


namespace app\repository\admin;

use app\repository\abstracts\AdminRepo;

class AnimalRepo extends AdminRepo {

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

       if (!empty($friendId)){
           $this->db->update(['friend_id' => NULL])->where('friend_id', $friendId)->save();
           $this->db->update(['friend_id' => NULL])->where('friend_id', $animalId)->save();
           $this->db->update(['friend_id' => $animalId])->where('animal_id', $friendId)->save();
           $this->db->update(['friend_id' => $friendId])->where('animal_id', $animalId)->save();
       }
       return $id;
    }


    public function delete($id) {
        $this->db->update(['friend_id' => NULL])->where('friend_id', $id)->save();
        $this->db->delete()->where('animal_id', $id)->save();
    }


}
