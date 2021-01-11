<?php


namespace app\controllers\admin;


use app\database\Database;
use app\models\Media;
use app\Router;
use app\Validator;

class MediaController extends BaseController {
    public $name = 'Media';
    public $table = 'media';
    public $urls = [
        'browse' => '/admin/media',
        'details' => '/admin/media/details',
        'delete' => '/admin/media/delete'
    ];

    public function __construct(){
        $this->model = new Media();
    }

    public function save($router){
        $errors = [];
        $fields = $this->getDetailsFields($this->table, $router);
        if ($_POST) {
            $array = Validator::sanitiseAll($_POST);
            $filename = $array['category']."/".$array['subcategory'];
            $errors = $this->uploadFile($filename);
            if (empty($errors) or errors[0] === "Sorry, file already exists."){
                $array['filename'] = $filename."/".$_FILES['filename']['name'];
                $media = new Media($array);
                $errors = $media->save();
                if(empty($errors)) {
                    $router->redirect('/admin/media');
                }
            }
        }
        return $router->renderView('/admin/details', [
            'fields' => $fields,
            'errors' => $errors,
            'title' => $this->name,
            'actions' => $this->urls,
            'inputs' => $this->model->_detailsTypes,
            'options' => $this->model->getAllOptions($router->db)
        ]);
    }

    protected function uploadFile($filepath) {
        $target_dir = $filepath;
        $target_file = $_SERVER['DOCUMENT_ROOT']."/images/".$target_dir .'/'.basename($_FILES["filename"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["filename"]["tmp_name"]);
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

       if (!move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
           return ["Sorry, there was an error uploading your file."];
       }
    }
}
