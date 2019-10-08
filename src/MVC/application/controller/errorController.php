<?php

class ErrorController
{

    private $pdModel;

    public function __construct()
    {
        if(file_exists('application/models/pizzadeliverymodel.php')){
            require_once 'application/models/pizzadeliverymodel.php';
            $this->pdModel = new PizzaDeliveryModel();
            session_start();
        }else{
            exit("ERRORE nel costruttore della classe consegne dei controller.");
        }
    }

    public function requireConnectionError(){
        require 'application/views/_templates/headers/error.php';
        require 'application/views/error/errorDBConnection.php';
        require 'application/views/_templates/footer.php';
    }

    public function requireQueryError(){
        require 'application/views/_templates/headers/error.php';
        require 'application/views/error/queryError.php';
        require 'application/views/_templates/footer.php';
    }

    public function emptyCart(){
        require 'application/views/_templates/headers/error.php';
        require 'application/views/error/emptyCartError.php';
        require 'application/views/_templates/footer.php';
    }

    private function getRightHeader(){
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            switch($user['tipoUtente']){
                case "impiegato vendita":
                    require 'application/views/_templates/headers/impiegato.php';
                    break;
                case "fattorino":
                    require 'application/views/_templates/headers/fattorino.php';
                    break;
                case "amministratore":
                    require 'application/views/_templates/headers/admin.php';
                    break;
            }
        }else{
            require 'application/views/_templates/headers/header.php';
        }
    }

}
