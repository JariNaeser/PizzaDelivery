<?php

class GestionePizzeria
{

    private $pdModel;

    public function __construct()
    {
        if(file_exists('application/models/pizzadeliverymodel.php')){
            require_once 'application/models/pizzadeliverymodel.php';
            $this->pdModel = new PizzaDeliveryModel();
            session_start();
        }else{
            exit("ERRORE nel costruttore della classe consegne dei controller.");
        }
    }

    public function gestionePizzeria(){

        $_SESSION['utenti'] = $this->pdModel->getUtenti();

        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/gestionePizzeria/gestionePizzeria.php';
        require 'application/views/_templates/footer.php';
    }

    public function modifyUser(string $username){

        $_SESSION['userToModify'] = $this->pdModel->getUser($username);

        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/gestionePizzeria/editUser.php';
        require 'application/views/_templates/footer.php';
    }

    public function creaUtente(){

        $_SESSION['userTypes'] = $this->pdModel->getUserTypes();

        // Carico Views
        $this->getRightHeader();
        require 'application/views/pages/gestionePizzeria/creaUser.php';
        require 'application/views/_templates/footer.php';
    }

    public function modifyUserContent(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['nomeMU'])&&isset($_POST['cognomeMU'])&&isset($_POST['viaMU'])&&isset($_POST['capMU'])&&isset($_POST['paeseMU'])&&isset($_POST['emailMU'])&&isset($_POST['tipologiaMU'])){
                if(isset($_POST['passwordMU']) && strlen(trim($_POST['passwordMU'])) != 0){
                    $password = $_POST['passwordMU'];
                }else{
                    $password = $_SESSION['userToModify'][0]['password'];
                }

                $nome = strtolower($_POST['nomeMU']);
                $cognome = strtolower($_POST['cognomeMU']);
                $via = $_POST['viaMU'];
                $cap = $_POST['capMU'];
                $paese = $_POST['paeseMU'];
                $email = $_POST['emailMU'];
                $tipologia = $_POST['tipologiaMU'];

                $this->pdModel->insertQuery(  "UPDATE utente SET nome='$nome', cognome='$cognome', via='$via', cap='$cap', paese='$paese', email='$email', password='$password', tipoUtente='$tipologia' WHERE username = '$nome.$cognome'");
                $this->gestionePizzeria();
            }
        }
    }

    public function eliminaUtente(string $username){
        $this->pdModel->dropUser($username);
        $this->gestionePizzeria();
    }

    public function createUser(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['nomeNU'])&&isset($_POST['cognomeNU'])&&isset($_POST['viaNU'])&&isset($_POST['capNU'])&&isset($_POST['paeseNU'])&&isset($_POST['emailNU'])&&isset($_POST['passwordNU'])&&isset($_POST['tipologiaNU'])){
                $this->pdModel->insertQuery("INSERT INTO utente VALUES ('" . strtolower($_POST['nomeNU']) . "." . strtolower($_POST['cognomeNU']) . "', '" . $_POST['nomeNU'] ."', '" . $_POST['cognomeNU'] . "', '" . $_POST['viaNU'] . "', '" . $_POST['capNU'] . "', '" . $_POST['paeseNU'] . "', '" . $_POST['emailNU'] . "', '" . $_POST['passwordNU'] . "', '" . $_POST['tipologiaNU'] . "');");
                $this->gestionePizzeria();
            }
        }
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

}
