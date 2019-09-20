<?php

class Home
{

    private $pdModel;

    public function __construct()
    {
        if(file_exists('application/models/pizzadeliverymodel.php')){
            require_once 'application/models/pizzadeliverymodel.php';
            $this->pdModel = new PizzaDeliveryModel();
        }else{
            exit("ERRORE nel costruttore della classe home dei controller.");
        }
    }

    public function index(){
        if(isset($this->pdModel)){
            $_SESSION['utenti'] = $this->pdModel->execQuery("SELECT * FROM utente;");
            // Carico Views
            require 'application/views/_templates/header.php';
            require 'application/views/pages/benvenuto.php';
            require 'application/views/_templates/footer.php';
        }else{
            $this->requireError();
        }
    }

    public function ordina(){
        if(isset($this->pdModel)){
            $_SESSION['articoli'] = $this->pdModel->execQuery("SELECT * FROM articolo;");
            require 'application/views/_templates/header.php';
            require 'application/views/pages/ordina.php';
            require 'application/views/_templates/footer.php';
        }else{
            $this->requireError();
        }
    }

    public function requireError(){
        require 'application/views/_templates/header.php';
        require 'application/views/error/errorDBConnection.php';
        require 'application/views/_templates/footer.php';
    }


}
