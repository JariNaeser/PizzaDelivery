<?php

class Home
{

    public function index()
    {
        //Istanzio model
        if(file_exists('application/models/pizzadeliverymodel.php')){
            require_once 'application/models/pizzadeliverymodel.php';
            $pdModel = new PizzaDeliveryModel();
            session_start();
            $_SESSION['DATA'] = $pdModel->execQuery("SELECT * FROM utente;");
        }else{
            $_SESSION['DATA'] = "ERRORE nella classe home dei controller.";
        }

        // Carico Views
        require 'application/views/_templates/header.php';
        require 'application/views/pages/benvenuto.php';
        require 'application/views/_templates/footer.php';
    }


}
