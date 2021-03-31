<?php


namespace app\classes;


class FileUploader {

    protected array $model;
    protected array $validFileExtensions = ["jpg", "png", "jpeg", "gif"];
    protected int $maxSize = 500000;

    public function __construct($model, $files) {
        $this->model = $model;
        $this->files = $files;
    }

    public function getFileName(){
        ['category' => $category] = $this->model;
        $file = $this->files['filename']['name'];
        return "/$category/$file";
    }

    public function getFilePath(){
        $filename = $this->getFileName();
        $files =  $this->files;
        return $_SERVER['DOCUMENT_ROOT']."/images".$filename.'/'.basename($files["filename"]["name"]);
    }

    public function getFileExtension(){
        $filepath = $this->getFilePath();
        return strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
    }

    public function upload(){
        $this->checkImage();
        $this->checkNew();
        $this->checkSize();
        $this->checkExtension();
        $this->checkMoved();
    }

    public function checkImage(){
        $request = Request::getInstance();
        if ($request->has('submit')) {
            $check = getimagesize($this->files["filename"]["tmp_name"]);
            if ($check === false) {
                throw new FailedValidation(["File is not an image"]);
            }
        }
    }
    public function checkNew(){
        $filepath = $this->getFilePath();
        if (file_exists($filepath)) {
            throw new FailedValidation(["Sorry, file already exists."]);
        }
    }
    public function checkSize(){
        if ($this->files["filename"]["size"] > $this->maxSize) {
            throw new FailedValidation(["Sorry, your file is too large."]);
        }
    }

    public function checkExtension(){
        $extension = $this->getFileExtension();
        if (!in_array($extension, $this->validFileExtensions)){
            throw new FailedValidation(["File extension not currently supported"]);
        }
    }

    public function checkMoved(){
        $filepath = $this->getFilePath();
        if (!move_uploaded_file($this->files["filename"]["tmp_name"], $filepath)) {
            throw new FailedValidation(["Sorry, there was an error uploading your file."]);
        }
    }

}
