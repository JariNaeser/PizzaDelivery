<?php

require_once 'rightHeader.php';

class Login
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
                $utenti = $this->getUtenti();
                $user = null;

                foreach ($utenti as $utente){
                    if(strcmp($utente['username'], $username) == 0){
                        $user = $utente;
                        break;
                    }
                }

                if(isset($user) && strcmp($user['password'], $password) == 0){
                    $_SESSION['user'] = $user;

                    $this->header->getRightHeader();
                    require 'application/views/pages/index/benvenuto.php';
                    require 'application/views/_templates/footer.php';
                }else{
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
    }

    public function logout(){
        // Carico Views
        $_SESSION['user'] = null;
        header("Location: " . URL . "home/index");
    }

}
