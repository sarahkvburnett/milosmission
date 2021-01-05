<?php


namespace app\controllers\admin;


use app\database\Database;
use app\models\Media;
use app\Validator;

class MediaController {
    static public $urls = [
        'browse' => '/admin/media',
        'details' => '/admin/media/details',
        'delete' => '/admin/media/delete'
    ];

    static public function browse($router){
        $searchColumn = $_GET['searchColumn'] ?? '';
        $searchItem = $_GET['searchItem'] ?? '';
        $search = [
            'column' => $searchColumn,
            'item' => $searchItem
        ];
        $fields = Database::$db->findAll('media', $search);
        $updatedFields = [];
        foreach( $fields as $field){
            $newField = array_slice($field, 0, 2, true) +
                array('preview' => $field['filename']) +
                array_slice($field, 2, NULL, true);
            $updatedFields[] = $newField;
        };
        return $router->renderView('/admin/browse', [
            'fields' => $updatedFields,
            'title' => 'Media',
            'searchables' => Media::$search,
            'actions' => self::$urls,
            'search' => $search,
        ]);
    }

    static public function save($router){
        $errors = [];
        $fields = [];
        if (isset($_GET['id'])) {
            $fields = Database::$db->findOneById('media', $_GET['id']);
        } else {
            $data = Database::$db->describe('media');
            foreach ($data as $item){
                $fields[$item['Field']] = '';
            }
        }
        if ($_POST) {
            $array = Validator::sanitiseAll($_POST);
            $filename = $array['category']."/".$array['subcategory'];
            $errors = self::uploadFile($filename);
            if (empty($errors) or errors[0] === "Sorry, file already exists."){
                $array['filename'] = $filename."/".$_FILES['filename']['name'];
                $media = new Media($array);
                $errors = $media->save();
                if(empty($errors)) {
                    header("Location: /admin/media");
                    exit;
                }
            }
        }
        return $router->renderView('/admin/details', [
            'fields' => $fields,
            'errors' => $errors,
            'title' => 'Media',
            'actions' => self::$urls,
            'inputs' => Media::$inputs,
            'options' => Media::options(),
        ]);
    }

    static public function delete($router){
        $id = $_POST['id'];
        Database::$db->deleteOneById('media', $id);
        header('Location: /admin/media');
        exit;
    }

    static protected function uploadFile($filepath) {
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
