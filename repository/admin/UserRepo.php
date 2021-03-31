<?php


namespace app\repository\admin;

use app\repository\abstracts\AdminRepo;

class UserRepo extends AdminRepo {

    public function findOneByEmail($email){
        return $this->db->select()->where('user_email', "'$email'")->findOne();
    }

}
