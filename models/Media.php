<?php


namespace app\models;


use app\database\Database;
use app\models\abstracts\Admin;

class Media extends Admin {

    protected $media_id;
    protected $media_filename;
    protected $media_type;
    protected $media_category;
    protected $media_subcategory;

    //todo sort out media-id image replacement

    function setTable() {
        $this->_table = 'media';
    }

    function setName() {
        $this->_name = 'Media';
    }

    public function validate() {
        $errors = [];
        if (!$this->media_filename) {
            $errors[] = "Please add a file";
        }
        if (!$this->media_type) {
            $errors[] = "Please indicate the filetype";
        }
        if (!$this->media_category) {
            $errors[] = "Please indicate the category";
        }
        if (!$this->media_subcategory) {
            $errors[] = "Please indicate the subcategory";
        }
        return $errors;
    }

}
