<?php


namespace app\controllers\admin;

use app\controllers\abstracts\Admin;

class Media extends Admin {

    //todo img preview

    function setClass() {
        $this->class = "Media";
    }

    function setTable() {
        $this->table = "media";
    }

    protected function setBrowseData($router, $search = []) {
        $this->addDataField(
            'fields',
            $router->db
                ->select($this->table, ['*', 'media_filename AS preview'])
                ->where($search)
                ->fetchAll()
        );
    }

    //todo need to add new entry into animal_media;
    public function save($router, $data){
        if ($_FILES) {
            $array = Validator::sanitiseAll($data);
            $filename = "/".$array['category'];
            $errors = $this->uploadFile($_FILES, $filename);
            if (empty($errors) or $errors[0] === "Sorry, file already exists."){
                $array['filename'] = $filename."/".$_FILES['filename']['name'];
                $model = new $this->model($array);
                $errors = $model->validate();
                if(empty($errors)) {
                    $model->save($router->db);
                    $this->data['fields'] = $array;
                    $router->redirect($this->urls['browse'], $this->data);
                }
             }
        }
        return $router->sendResponse('/admin/details', $this->data);
    }

    protected function uploadFile($files, $filepath) {
        $target_dir = $filepath;
        $target_file = $_SERVER['DOCUMENT_ROOT']."/images".$target_dir .'/'.basename($files["filename"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (isset($_POST["submit"])) {
            $check = getimagesize($files["filename"]["tmp_name"]);
            if ($check === false) {
                return ["File is not an image"];
            }
        }
        if (file_exists($target_file)) {
            return ["Sorry, file already exists."];
        }
//        if ($_FILES["filename"]["size"] > 500000) {
//            return ["Sorry, your file is too large."];
//        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
           return ["Sorry, only JPG, JPEG, PNG & GIF files are allowed."];
        }

       if (!move_uploaded_file($files["filename"]["tmp_name"], $target_file)) {
           return ["Sorry, there was an error uploading your file."];
       }
    }

    protected function deleteFile(){
        //todo
    }

}
