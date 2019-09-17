<?php

class Home
{

    public function index()
    {
        //Istanzio model


        // Carico Views
        require 'application/views/_templates/header.php';
        require 'application/views/pages/benvenuto.php';
        require 'application/views/_templates/footer.php';
    }


}
