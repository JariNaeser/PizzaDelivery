<?php

class Ordinazioni
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

    public function ordinazioni(){

        $_SESSION['ordinazioni'] = $this->pdModel->getPreparedOrdinazioni();

        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/ordinazioni/ordinazioni.php';
        require 'application/views/_templates/footer.php';
    }

    public function ordinazione(int $id){

        $_SESSION['ordine'] = $this->pdModel->getOrdine($id);
        $_SESSION['articoli'] = $this->pdModel->getArticoli();

        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/ordinazioni/ordinazione.php';
        require 'application/views/_templates/footer.php';
        //header("Location: " . PAGES . "ordinazione");
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
