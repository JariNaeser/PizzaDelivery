<?php

require_once 'rightHeader.php';

class Fattorini
{

    private $pdModel;
    private $header;

    public function __construct()
    {
        if(file_exists('application/models/fattoriniModel.php')){
            require_once 'application/models/fattoriniModel.php';
            $this->pdModel = new FattoriniModel();
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

    public function fattorino(string $username){

        $_SESSION['fattorino'] = $this->pdModel->getFattorino($username);
        $_SESSION['userFattorino'] = $this->pdModel->getUser($username);
        $_SESSION['consegneFattorino'] = $this->pdModel->getConsegne($username);


        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/fattorini/fattorino.php';
        require 'application/views/_templates/footer.php';
    }

}
