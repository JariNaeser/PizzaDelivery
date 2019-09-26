<?php

class Home
{

    private $pdModel;
    private $cart;

    public function __construct()
    {
        if(file_exists('application/models/pizzadeliverymodel.php')){
            require_once 'application/models/pizzadeliverymodel.php';
            $this->pdModel = new PizzaDeliveryModel();
                $this->cart = array();
            session_start();
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
        $_SESSION['articoli'] = $this->execQuery("SELECT * FROM articolo;");
        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/ordina.php';
        require 'application/views/_templates/footer.php';
    }

    public function loginForm(){
        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/login.php';
        require 'application/views/_templates/footer.php';
    }

    public function ordinazioni(){
        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/ordinazioni.php';
        require 'application/views/_templates/footer.php';
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

    public function requireError(){
        require 'application/views/_templates/headers/error.php';
        require 'application/views/error/errorDBConnection.php';
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
                $utenti = $this->execQuery("SELECT * FROM utente;");
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

    public function addToCart($nome){
        if(isset($_SESSION['articoli'])){
            foreach ($_SESSION['articoli'] as $articolo){
                if(strcmp($articolo['nome'], $nome) == 0){
                    array_push($this->cart, $articolo);
                    break;
                }
            }
        }
        $_SESSION['cart'] = $this->cart;
        $this->ordina();
    }






    /**
     * Metodo che si occupa di gestire una connessione inesistente oppure non corretta,
     * usando questo metodo abbastanza complesso è così possibile evitare blocchi ripetitivi nel codice
     * rendendolo così molto più pulito.
     *
     * @param string $query Query da eseguire sul DB.
     * @return array|string Array contenente l'output della query oppure il messaggio di errore.
     */
    private function execQuery(string $query){
        //Controllo se è stata istanziata la connessione.
        if(isset($this->pdModel)){
            //Eseguo la query.
            $tmp = $this->pdModel->execQuery($query);
            //È stringa?
            if(is_string($tmp)){
                //Se si
                if(strcmp($tmp, ERROR_MESSAGE) == 0){
                    //Richiama pagina errore
                    $this->requireError();
                    //Esci dal programma per non ritornare nessun dato
                    exit;
                }
            }
            //Se query va a buon fine ritorna l'output
            return $tmp;
        }else{
            //Richiama pagina errore se oggetto $pdModel non è istanziato
            $this->requireError();
        }
    }

}
