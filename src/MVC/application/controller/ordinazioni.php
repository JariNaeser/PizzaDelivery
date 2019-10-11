<?php

require_once 'rightHeader.php';

class Ordinazioni
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
            exit("ERRORE nel costruttore della classe ordinazioni dei controller.");
        }
    }

    public function home(){

        $_SESSION['ordinazioni'] = $this->pdModel->getPreparedOrdinazioni();

        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/ordinazioni/ordinazioni.php';
        require 'application/views/_templates/footer.php';
    }

    public function ordinazione(int $id){

        $_SESSION['ordine'] = $this->pdModel->getOrdine($id);
        $_SESSION['articoli'] = $this->pdModel->getArticoli();

        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/ordinazioni/ordinazione.php';
        require 'application/views/_templates/footer.php';
        //header("Location: " . PAGES . "ordinazione");
    }

}
