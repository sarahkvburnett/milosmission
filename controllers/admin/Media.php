<?php


namespace app\controllers\admin;

use app\classes\FileUploader;
use app\classes\Request;
use app\controllers\abstracts\Admin;
use app\controllers\abstracts\iController;
use app\database\Database;
use app\classes\Validator;

class Media extends Admin implements iController{

    //todo img preview

    //todo this is well old mate - fileuploader class
    //todo need to add new entry into animal_media;
    public function save($data){
        $request = Request::getInstance();
        $model = $this->validate($data);
        $files = $request->getFiles();
        $uploader = new FileUploader($model, $files);
        if(isset($this->id)){
            return $this->repo->update($this->id, $model);
        } else {
            return $this->repo->insert($model);
        }
    }

    protected function deleteFile(){
        //todo
    }

}
