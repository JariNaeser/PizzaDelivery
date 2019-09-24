<?php

class Home
{

    private $pdModel;

    public function __construct()
    {
        if(file_exists('application/models/pizzadeliverymodel.php')){
            require_once 'application/models/pizzadeliverymodel.php';
            $this->pdModel = new PizzaDeliveryModel();
        }else{
            exit("ERRORE nel costruttore della classe home dei controller.");
        }
    }

    public function index(){
        $_SESSION['utenti'] = $this->execQuery("SELECT * FROM utente;");
        // Carico Views
        require 'application/views/_templates/headers/header.php';
        require 'application/views/pages/benvenuto.php';
        require 'application/views/_templates/footer.php';
    }

    public function ordina(){
        $_SESSION['articoli'] = $this->execQuery("SELECT * FROM articolo;");
        // Carico Views
        require 'application/views/_templates/headers/header.php';
        require 'application/views/pages/ordina.php';
        require 'application/views/_templates/footer.php';
    }

    public function requireError(){
        require 'application/views/_templates/headers/default.php';
        require 'application/views/error/errorDBConnection.php';
        require 'application/views/_templates/footer.php';
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
