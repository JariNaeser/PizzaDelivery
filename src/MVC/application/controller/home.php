<?php

class Home
{

    private $pdModel;

    public function __construct()
    {
        if(file_exists('application/models/pizzadeliverymodel.php')){
            require_once 'application/models/pizzadeliverymodel.php';
            $this->pdModel = new PizzaDeliveryModel();
            $this->cart = array();
            session_start();
            if(!isset($_SESSION['cart'])){
                $_SESSION['cart'] = [];
            }

            //Per svuotare le sessioni
            if(false){
                $_SESSION['cart'] = [];
            }

        }else{
            exit("ERRORE nel costruttore della classe home dei controller.");
        }
    }

    /* FRONTEND METHODS */

    public function index(){
        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/benvenuto.php';
        require 'application/views/_templates/footer.php';
    }

    public function ordina(){
        $_SESSION['articoli'] = $this->pdModel->getArticoliOrdinati();
        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/ordina.php';
        require 'application/views/_templates/footer.php';

    }

    public function confermaordine(){
        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/confermaOrdine.php';
        require 'application/views/_templates/footer.php';
    }

    public function loginForm(){
        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/login.php';
        require 'application/views/_templates/footer.php';
    }

    public function ordinazioni(){

        $_SESSION['ordinazioni'] = $this->pdModel->getPreparedOrdinazioni();

        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/ordinazioni.php';
        require 'application/views/_templates/footer.php';
    }

    public function ordinazione(int $id){

        $_SESSION['ordine'] = $this->pdModel->getOrdine($id);
        $_SESSION['articoli'] = $this->pdModel->getArticoli();

        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/ordinazione.php';
        require 'application/views/_templates/footer.php';
        //header("Location: " . PAGES . "ordinazione");
    }

    public function consegne(){
        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/consegne.php';
        require 'application/views/_templates/footer.php';
    }

    public function fattorini(){
        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/fattorini.php';
        require 'application/views/_templates/footer.php';
    }

    public function gestionePizzeria(){
        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/gestionePizzeria.php';
        require 'application/views/_templates/footer.php';
    }

    public function logout(){
        // Carico Views
        $_SESSION['user'] = null;
        $this->index();
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

    private function getRightHeader(){
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            switch($user['tipoUtente']){
                case "impiegato vendita":
                    require 'application/views/_templates/headers/impiegato.php';
                    break;
                case "fattorino":
                    require 'application/views/_templates/headers/fattorino.php';
                    break;
                case "amministratore":
                    require 'application/views/_templates/headers/admin.php';
                    break;
            }
        }else{
            require 'application/views/_templates/headers/header.php';
        }
    }

    /* BACKEND METHODS */

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['username']) && isset($_POST['password'])){
                $username = htmlspecialchars(stripslashes($_POST['username']));
                $password = htmlspecialchars(stripslashes($_POST['password']));
                $utenti = $this->pdModel->getUtenti();
                $user = null;

                foreach ($utenti as $utente){
                    if(strcmp($utente['username'], $username) == 0){
                        $user = $utente;
                        break;
                    }
                }

                if(isset($user) && strcmp($user['password'], $password) == 0){

                    $_SESSION['user'] = $user;

                    $this->getRightHeader();
                    require 'application/views/pages/benvenuto.php';
                    require 'application/views/_templates/footer.php';

                }else{
                    $this->loginForm();
                    echo "Errore: Utente o password errati.";
                }
            }
        }
    }

    public function addToCart($id){
        $id = (int)$id;
        if(isset($_SESSION['cart']) && is_int($id)){
            $item = $this->pdModel->getArticolo($id);
            if(!in_array($item, $_SESSION['cart'])){
                array_push($_SESSION['cart'], $item);
            }
        }
        header("Location: " . PAGES . "ordina");
        $this->ordina();
    }

    public function removeFromCart($id){
        $arr = array();
        if(isset($_SESSION['cart'])){
            foreach($_SESSION['cart'] as $element){
                if($element[0]['id'] != $id){
                    array_push($arr, $element);
                }
            }
            $_SESSION['cart'] = $arr;
        }
        header("Location: " . PAGES . "ordina");
        $this->ordina();
    }

    public function creaOrdine(){
        //Crea ordine.
        if(isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['numeroTelefono']) && isset($_POST['paese']) && isset($_POST['cap']) && isset($_POST['via']) && isset($_POST['numero']) && isset($_SESSION['cart'])){

            $nome = $_POST['nome'];
            $cognome = $_POST['cognome'];
            (int)$telefono = $_POST['numeroTelefono'];
            $paese = $_POST['paese'];
            $cap = $_POST['cap'];
            $via = $_POST['via'] . " " . $_POST['numero'];

            //Insert into ordine
            $id = $this->pdModel->insertQuery("INSERT INTO Ordinazione(nomeCliente, cognomeCliente, numeroTelefonoCliente, via, cap, paese) VALUES ('$nome', '$cognome', $telefono, '$via', $cap, '$paese');");

            //Insert into OrdineArticolo
            foreach ($_SESSION['cart'] as $element){
                $this->pdModel->insertQuery("INSERT INTO OrdineArticolo VALUES ($id, '" . $element[0]['id'] . "', " . $_POST['select' . $element[0]['id']] . ");");
            }

            //Se andato a buon fine
            $this->getRightHeader();
            require 'application/views/pages/ringraziamentoOrdine.php';
            require 'application/views/_templates/footer.php';

            //Azzera contenuto carrello
            $_SESSION['cart'] = null;
        }
    }

}
