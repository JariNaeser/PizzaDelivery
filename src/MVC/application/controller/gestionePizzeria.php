<?php

require_once 'rightHeader.php';

class GestionePizzeria
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
            $_SESSION['userTypes'] = $this->pdModel->getUserTypes();
        }else{
            exit("ERRORE nel costruttore della classe gestionePizzeria dei controller.");
        }
    }

    public function home(){

        $_SESSION['utenti'] = $this->pdModel->getUtenti();
        $_SESSION['prodotti'] = $this->pdModel->getArticoliOrdinati();

        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/gestionePizzeria/gestionePizzeria.php';
        require 'application/views/_templates/footer.php';
    }

    /* UTENTI */

    public function modifyUser(string $username){

        $_SESSION['userToModify'] = $this->pdModel->getUser($username);

        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/gestionePizzeria/editUser.php';
        require 'application/views/_templates/footer.php';
    }

    public function modifyUserContent(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['nomeMU'])&&isset($_POST['cognomeMU'])&&isset($_POST['viaMU'])&&isset($_POST['capMU'])&&isset($_POST['paeseMU'])&&isset($_POST['emailMU'])&&isset($_POST['tipologiaMU'])){
                if(isset($_POST['passwordMU']) && strlen(trim($_POST['passwordMU'])) != 0){
                    $password = hash('sha256', $_POST['passwordMU']);
                }else{
                    $password = $_SESSION['userToModify'][0]['password'];
                }

                //Prepare variables for query
                $nome = strtolower($_POST['nomeMU']);
                $cognome = strtolower($_POST['cognomeMU']);
                $via = $_POST['viaMU'];
                $cap = $_POST['capMU'];
                $paese = $_POST['paeseMU'];
                $email = $_POST['emailMU'];
                $tipologia = $_POST['tipologiaMU'];

                $this->pdModel->insertQuery(  "UPDATE utente SET nome='$nome', cognome='$cognome', via='$via', cap='$cap', paese='$paese', email='$email', password='$password', tipoUtente='$tipologia' WHERE username = '$nome.$cognome'");
                $this->home();
            }
        }
    }

    public function eliminaUtente(string $username){
        $this->pdModel->dropUser($username);
        $this->home();
    }

    public function creaUtente(){
        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/gestionePizzeria/creaUser.php';
        require 'application/views/_templates/footer.php';
    }

    public function createUser(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['nomeNU'])&&isset($_POST['cognomeNU'])&&isset($_POST['viaNU'])&&isset($_POST['capNU'])&&isset($_POST['paeseNU'])&&isset($_POST['emailNU'])&&isset($_POST['passwordNU'])&&isset($_POST['tipologiaNU'])){
                $this->pdModel->insertQuery("INSERT INTO utente VALUES ('" . strtolower($_POST['nomeNU']) . "." . strtolower($_POST['cognomeNU']) . "', '" . $_POST['nomeNU'] ."', '" . $_POST['cognomeNU'] . "', '" . $_POST['viaNU'] . "', '" . $_POST['capNU'] . "', '" . $_POST['paeseNU'] . "', '" . $_POST['emailNU'] . "', '" . hash('sha256', $_POST['passwordNU']) . "', '" . $_POST['tipologiaNU'] . "');");
                header("Location: " . URL . "gestionePizzeria/home");
                $this->home();
            }
        }
    }

    /* ARTICOLI */

    public function modifyArticolo(int $id){

        $_SESSION['articoloToModify'] = $this->pdModel->getArticolo($id);

        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/gestionePizzeria/editArticolo.php';
        require 'application/views/_templates/footer.php';
    }

    public function modifyArticoloContent(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['nomeMA'])&&isset($_POST['descrizioneMA'])&&isset($_POST['prezzoMA'])&&isset($_SESSION['articoloToModify'])){

                $nome = $_POST['nomeMA'];
                $descrizione = $_POST['descrizioneMA'];
                $prezzo = $_POST['prezzoMA'];

                if(isset($_POST['pathImmaginaMA']) && strlen($_POST['pathImmaginaMA']) > 0){
                    $path = $_POST['pathImmaginaMA'];
                    $this->pdModel->insertQuery(  "UPDATE articolo SET nome='$nome', descrizione='$descrizione', prezzo=$prezzo, urlFoto='$path' WHERE id = " . $_SESSION['articoloToModify'][0]['id'] . ";");
                }else{
                    $this->pdModel->insertQuery(  "UPDATE articolo SET nome='$nome', descrizione='$descrizione', prezzo=$prezzo WHERE id = " . $_SESSION['articoloToModify'][0]['id'] . ";");
                }
                $this->home();
            }
        }
    }

    public function eliminaArticolo(int $id){
        $this->pdModel->dropArticolo($id);
        $this->home();
    }

    public function creaArticolo(){
        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/gestionePizzeria/creaArticolo.php';
        require 'application/views/_templates/footer.php';
    }

    public function createArticolo(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['nomeNA'])&&isset($_POST['descrizioneNA'])&&isset($_POST['prezzoNA'])){
                if(isset($_POST['nomeImmaginaNA']) && strlen($_POST['nomeImmaginaNA']) > 0){
                    $this->pdModel->insertQuery("INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ('" . $_POST['nomeNA'] . "', '" . $_POST['descrizioneNA'] ."'," . $_POST['prezzoNA'] . ", '" . $_POST['nomeImmaginaNA'] . "');");
                }else{
                    $this->pdModel->insertQuery("INSERT INTO Articolo(nome, descrizione, prezzo) VALUES ('" . $_POST['nomeNA'] . "', '" . $_POST['descrizioneNA'] ."'," . $_POST['prezzoNA'] .");");
                }
                header("Location: " . URL . "gestionePizzeria/home");
                $this->home();
            }
        }
    }

}
