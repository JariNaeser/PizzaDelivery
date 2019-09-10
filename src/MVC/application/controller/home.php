<?php


class Home
{

    private $utentiModel;

    public function __construct(){
        if(file_exists('application/models/utentimodel.php')){
            require 'application/models/utentimodel.php';
            $this->utentiModel = new utentimodel();
        }else{
            exit;
        }
    }

    public function index()
    {
        require 'application/views/_templates/header.php';
        require 'application/views/home/index.php';
        require 'application/views/_templates/footer.php';
    }

    public function login(){
        $this->utentiModel->login();
    }


}
