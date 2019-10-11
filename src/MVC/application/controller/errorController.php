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
            exit("ERRORE nel costruttore della classe errorController dei controller.");
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

    public function emptyCartError(){
        require 'application/views/_templates/headers/error.php';
        require 'application/views/error/emptyCartError.php';
        require 'application/views/_templates/footer.php';
    }

}
