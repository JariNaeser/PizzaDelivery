<?php

require_once 'rightHeader.php';

class Consegne
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
            exit("ERRORE nel costruttore della classe consegne dei controller.");
        }
    }

    public function home(int $weeks){

        $_SESSION['consegne'] = $this->pdModel->getConsegneConData($weeks);
        $_SESSION['consegne']['dropDownValue'] = $weeks;

        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/consegne/consegne.php';
        require 'application/views/_templates/footer.php';
    }

}
