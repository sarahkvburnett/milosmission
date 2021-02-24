<?php


namespace app\controllers\admin;

use app\controllers\abstracts\Admin;
use app\Router;
use http\Exception;

class Animal extends Admin {

    function setClass() {
        $this->class = 'Animal';
    }

    function setTable() {
        $this->table = 'animals';
    }

    public function setExistingDetailsData($router){
        $this->addDataField(
            'fields',
                $router->db
                ->select($this->table)
                ->join('media', 'media_id')
                ->where(['animal_id', $_GET['id']])
                ->fetch()
        );
        if (!empty($this->data['fields']['friend_id'])){
            $this->addDataField(
                'friend',
                $router->db
                    ->select($this->table)
                    ->where(['animal_id', $this->data['fields']['friend_id']])
                    ->fetch()
            );
        }
        if (!empty($this->data['fields']['animal_id'])){
            $this->addDataField(
                'media',
                $router->db
                    ->select('animal_media')
                    ->join('media', 'media_id')
                    ->where(['animal_id', $this->data['fields']['animal_id']])
                    ->fetchAll()
            );
        }
    }

    public function setBrowseData($router, $search = []){
        $this->addDataField(
            'fields',
            $router->db
                ->select($this->table, ['*', 'media.media_filename as image'])
                ->join('media', 'media_id')
                ->where($search)
                ->fetchAll()
        );
    }

    public function save($router, $data){
        $data['animal_id'] = parent::save($router, $data);
        $this->updateFriend($router, $data);
    }

    public function delete($router) {
        $this->deleteFriend($router);
        parent::delete($router);
    }

    /**
     * Update friendship pairings - remove old friend pairs (if applicable) and add new pair
     * @param Router $router
     * @param $data
     * @throws Exception
     */
    public function updateFriend($router, $data){
        //todo animal_id is null creating new animal
        $animalId = $data['animal_id'];
        $friendId = $data['friend_id'];
        try {
            $router->db->update('animals', ['friend_id' => NULL])->where(['friend_id', $friendId])->execute();
            $router->db->update('animals', ['friend_id' => NULL])->where(['friend_id', $animalId])->execute();
            $router->db->update('animals', ['friend_id' => $animalId])->where(['animal_id', $friendId])->execute();
            $router->db->update('animals', ['friend_id' => $friendId])->where(['animal_id', $animalId])->execute();
        } catch (Exception $e) {
            throw new \Exception('Friend not updated', 500);
        }
    }


    /**
     * Remove friendship pairing from newly deleted animal
     * @param Router $router
     */
    public function deleteFriend($router){
        $id = $_POST['id'];
        $router->db->update('animals', ['friend_id' => NULL])->where(['friend_id', $id])->execute();
    }

    //todo sort this out pls
    public function setCounts($router) {
        $idColumn = $this->class.'_id';
        $searchColumn = $this->class.'_status';
        $this->addCount('All', $idColumn, $router->db->count($idColumn, $this->table)->fetch(), '/admin/animals');
        $this->addCount('New', $idColumn, $router->db->count($idColumn, $this->table)->where([$searchColumn, "new"])->fetch(), '?searchValue=new&searchColumn='.$searchColumn);
        $this->addCount('Waiting', $idColumn, $router->db->count($idColumn, $this->table)->where([$searchColumn, "waiting"])->fetch(), '?searchValue=waiting&searchColumn='.$searchColumn);
        $this->addCount('Rehomed', $idColumn, $router->db->count($idColumn, $this->table)->where([$searchColumn, "rehomed"])->fetch(), '?searchValue=rehomed&searchColumn='.$searchColumn);
    }

    //todo need to delete friend on delete

}
