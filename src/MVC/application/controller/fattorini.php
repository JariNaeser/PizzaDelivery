<?php

require_once 'rightHeader.php';

class Fattorini
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
            exit("ERRORE nel costruttore della classe fattorini dei controller.");
        }
    }

    public function home(){

        $_SESSION['fattorini'] = $this->pdModel->getFattorini();

        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/fattorini/fattorini.php';
        require 'application/views/_templates/footer.php';
    }

}
