<?php

require_once 'rightHeader.php';

class Login
{

    private $pdModel;
    private $header;

    public function __construct()
    {
        if(file_exists('application/models/loginModel.php')){
            require_once 'application/models/loginModel.php';
            $this->pdModel = new LoginModel();
            $this->header = new RightHeader();
            session_start();
        }else{
            exit("ERRORE nel costruttore della classe login dei controller.");
        }
    }

    public function loginForm(){
        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/login/login.php';
        require 'application/views/_templates/footer.php';
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['username']) && isset($_POST['password'])){

                $username = htmlspecialchars(stripslashes($_POST['username']));
                $password = htmlspecialchars(stripslashes($_POST['password']));

                $utenti = $this->pdModel->getUtenti();
                $password = hash('sha256', $password);

                foreach ($utenti as $utente){

                    if(strcmp($utente['username'], $username) == 0 && strcmp($utente['password'], $password) == 0){

                        $_SESSION['user'] = $this->pdModel->getUser($username);

                        $this->header->getRightHeader();
                        require 'application/views/pages/index/benvenuto.php';
                        require 'application/views/_templates/footer.php';
                        exit;
                    }
                }

                $this->loginForm();
                echo "<div class=\"alert alert-warning alert-danger fade show padding-footer\" style='margin: 1em;' role=\"alert\">".
                    "<strong>Errore:</strong> Il nome utente oppure la password sono errati.".
                    "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                    "<span aria-hidden=\"true\">&times;</span>".
                    "</button>".
                    "</div>";


            }
        }
    }

    public function logout(){
        // Carico Views
        $_SESSION['user'] = null;
        header("Location: " . URL . "home/index");
    }

}
