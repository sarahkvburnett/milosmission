<?php


namespace app\models;


use app\database\Database;

class Post {
    public ?int $id;
    public ?string $label;
    public ?string $url;
    public ?string $caption;

    public function __construct($data){
        $this->id = $data['id'] ?? null;
        $this->label = $data['label'] ?? null;
        $this->url = $data['url'] ?? null;
        $this->caption = $data['caption'] ?? null;
    }

    public function save(){
        $errors = [];
        if (!$this->label) {
            $errors[] = "Please add a label";
        }
        if (!$this->url) {
            $errors[] = "Please add a url";
        }
        if (!$this->caption) {
            $errors[] = "Please add a caption";
        }
        if (empty($errors)){
            $db = Database::$db;
            $db->savePost($this);
        }
        return $errors;
    }

}
