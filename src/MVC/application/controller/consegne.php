<?php

require_once 'rightHeader.php';

class Consegne
{

    private $pdModel;
    private $header;

    public function __construct()
    {
        if(file_exists('application/models/consegneModel.php')){
            require_once 'application/models/consegneModel.php';
            $this->pdModel = new ConsegneModel();
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
