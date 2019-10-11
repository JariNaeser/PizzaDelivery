<?php

require_once 'rightHeader.php';

class Home
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
            exit("ERRORE nel costruttore della classe home dei controller.");
        }
    }

    /* FRONTEND METHODS */

    public function index(){
        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/index/benvenuto.php';
        require 'application/views/_templates/footer.php';
    }

}
