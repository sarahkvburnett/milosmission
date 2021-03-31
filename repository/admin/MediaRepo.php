<?php


namespace app\repository\admin;


use app\repository\abstracts\AdminRepo;

class MediaRepo extends AdminRepo {



    public function findAll($where) {
        return $this->db->select('*, media_filename AS preview')->where($where)->findAll();
    }


}
