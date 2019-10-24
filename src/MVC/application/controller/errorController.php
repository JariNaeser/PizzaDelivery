<?php

class ErrorController
{

    public function __construct()
    {
        session_start();
    }

    public function requireConnectionError(){
        require 'application/views/_templates/headers/error.php';
        require 'application/views/error/errorDBConnection.php';
        require 'application/views/_templates/footer.php';
    }

    public function requireQueryError(){
        require 'application/views/_templates/headers/error.php';
        require 'application/views/error/queryError.php';
        require 'application/views/_templates/footer.php';
    }

    public function emptyCartError(){
        require 'application/views/_templates/headers/error.php';
        require 'application/views/error/emptyCartError.php';
        require 'application/views/_templates/footer.php';
    }

    public function assegnaAFattorinoError(){
        require 'application/views/_templates/headers/error.php';
        require 'application/views/error/assegnaAFattorinoError.php';
        require 'application/views/_templates/footer.php';
    }

}
