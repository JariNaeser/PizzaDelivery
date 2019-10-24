<?php

require_once 'rightHeader.php';

class Home
{
    private $header;

    public function __construct()
    {
        $this->header = new RightHeader();
    }

    /* FRONTEND METHODS */

    public function index(){
        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/index/benvenuto.php';
        require 'application/views/_templates/footer.php';
    }

}
