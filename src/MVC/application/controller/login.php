<?php

require_once 'rightHeader.php';

class Login
{

    private $pdModel;
    private $header;

    public function __construct()
    {
        if(file_exists('application/models/pizzadeliverymodel.php')){
            require_once 'application/models/pizzadeliverymodel.php';
            $this->pdModel = new PizzaDeliveryModel();
            $this->header = new RightHeader();
            session_start();
        }else{
            exit("ERRORE nel costruttore della classe login dei controller.");
        }
    }

    public function loginForm(){
        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/login/login.php';
        require 'application/views/_templates/footer.php';
    }

    public function login(){
        $this->pdModel->login();
    }

    public function logout(){
        // Carico Views
        $_SESSION['user'] = null;
        header("Location: " . URL . "home/index");
    }

}
