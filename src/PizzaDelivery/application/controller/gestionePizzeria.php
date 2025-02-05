<?php

require_once 'rightHeader.php';

class GestionePizzeria
{

    private $pdModel;
    private $header;

    public function __construct()
    {
        if(file_exists('application/models/gestionePizzeriaModel.php')){
            require_once 'application/models/gestionePizzeriaModel.php';
            $this->pdModel = new GestionePizzeriaModel();
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
        if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0){
            $_SESSION['userToModify'] = $this->pdModel->getUser($username);

            // Carico Views
            $this->header->getRightHeader();
            require 'application/views/pages/gestionePizzeria/editUser.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function modifyUserContent(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
                if (isset($_POST['usernameMU']) && isset($_POST['nomeMU']) && isset($_POST['cognomeMU']) && isset($_POST['viaMU']) && isset($_POST['capMU']) && isset($_POST['paeseMU']) && isset($_POST['emailMU']) && isset($_POST['tipologiaMU'])) {

                    if(strcmp($this->pdModel->getUser($_POST['usernameMU'])[0]['tipoUtente'], 'amministratore') == 0 && strcmp($_POST['tipologiaMU'], 'amministratore') != 0 && $this->pdModel->getAdminsCount()[0]['adminsNum'] <= 1){
                        header("Location: " . URL . 'errorController/modifyLastAdmin');
                    }else{
                        if (isset($_POST['passwordMU']) && strlen(trim($_POST['passwordMU'])) != 0) {
                            $password = hash('sha256', $_POST['passwordMU']);
                        } else {
                            $password = $_SESSION['userToModify'][0]['password'];
                        }

                        $this->pdModel->updateUtente(
                            $_POST['usernameMU'],
                            $_POST['nomeMU'],
                            $_POST['cognomeMU'],
                            $_POST['viaMU'],
                            $_POST['capMU'],
                            $_POST['paeseMU'],
                            $_POST['emailMU'],
                            $password,
                            $_POST['tipologiaMU']
                        );

                        header("Location: " . URL . 'gestionePizzeria/home');
                        $this->home();
                    }
                }
            }
        }
    }

    public function eliminaUtente(string $username){
        if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
            //Check if user to delete is you
            if(strcmp($username, $_SESSION['user'][0]['username']) == 0){
                header("Location: " . URL . 'errorController/deleteYourSelf');
            }else{
                $response = $this->pdModel->dropUser($username);

                if (isset($response) && strcmp($response, "ERRORE") == 0) {
                    header("Location: " . URL . 'errorController/lastAdminDelete');
                } else {
                    header("Location: " . URL . 'gestionePizzeria/home');
                    $this->home();
                }
            }
        }
    }

    public function creaUtente(){
        if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
            // Carico Views
            $this->header->getRightHeader();
            require 'application/views/pages/gestionePizzeria/creaUser.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function createUser(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
                if (isset($_POST['nomeNU']) && isset($_POST['cognomeNU']) && isset($_POST['viaNU']) && isset($_POST['capNU']) && isset($_POST['paeseNU']) && isset($_POST['emailNU']) && isset($_POST['passwordNU']) && isset($_POST['tipologiaNU'])) {
                    $this->pdModel->insertUtente(
                        $_POST['nomeNU'],
                        $_POST['cognomeNU'],
                        $_POST['viaNU'],
                        $_POST['capNU'],
                        $_POST['paeseNU'],
                        $_POST['emailNU'],
                        $_POST['passwordNU'],
                        $_POST['tipologiaNU']
                    );

                    header("Location: " . URL . 'gestionePizzeria/home');
                    $this->home();
                }
            }
        }
    }

    /* ARTICOLI */

    public function modifyArticolo(int $id){
        if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
            $_SESSION['articoloToModify'] = $this->pdModel->getArticolo($id);

            // Carico Views
            $this->header->getRightHeader();
            require 'application/views/pages/gestionePizzeria/editArticolo.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function modifyArticoloContent(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
                if (isset($_POST['nomeMA']) && isset($_POST['descrizioneMA']) && isset($_POST['prezzoMA']) && isset($_SESSION['articoloToModify'])) {

                    if (isset($_POST['pathImmaginaMA']) && strlen($_POST['pathImmaginaMA']) > 0) {
                        $path = $_POST['pathImmaginaMA'];
                    } else {
                        $path = null;
                    }

                    $this->pdModel->updateArticolo(
                        $_POST['nomeMA'],
                        $_POST['descrizioneMA'],
                        $_POST['prezzoMA'],
                        $path,
                        $_SESSION['articoloToModify'][0]['id']
                    );

                    header("Location: " . URL . 'gestionePizzeria/home');
                    $this->home();
                }
            }
        }
    }

    public function eliminaArticolo(int $id){
        if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
            $this->pdModel->dropArticolo($id);
            header("Location: " . URL . 'gestionePizzeria/home');
            $this->home();
        }
    }

    public function creaArticolo(){
        if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
            // Carico Views
            $this->header->getRightHeader();
            require 'application/views/pages/gestionePizzeria/creaArticolo.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function createArticolo(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
                if (isset($_POST['nomeNA']) && isset($_POST['descrizioneNA']) && isset($_POST['prezzoNA'])) {

                    if (isset($_POST['pathImmaginaMA']) && strlen($_POST['pathImmaginaMA']) > 0) {
                        $path = $_POST['pathImmaginaMA'];
                    } else {
                        $path = null;
                    }

                    $this->pdModel->insertArticolo(
                        $_POST['nomeNA'],
                        $_POST['descrizioneNA'],
                        $_POST['prezzoNA'],
                        $path
                    );

                    header("Location: " . URL . 'gestionePizzeria/home');
                    $this->home();
                }
            }
        }
    }

    public function abilitaUtente(string $username){
        if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
            $this->pdModel->abilitaUtente($username);
            header("Location: " . URL . "gestionePizzeria/home");
        }
    }

    public function disabilitaUtente(string $username){
        if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
            if (strcmp($this->pdModel->getUser($username)[0]['tipoUtente'], 'amministratore') == 0) {
                $totNum = $this->pdModel->getAdminsCount()[0]['adminsNum'];
                if ($totNum <= 1) {
                    header("Location: " . URL . 'errorController/lastAdminDelete');
                    exit;
                }
            }
            $this->pdModel->disabilitaUtente($username);
            header("Location: " . URL . "gestionePizzeria/home");
        }
    }

    public function abilitaArticolo(string $id){
        if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
            $this->pdModel->abilitaArticolo(intval($id));
            header("Location: " . URL . "gestionePizzeria/home");
        }
    }

    public function disabilitaArticolo(string $id){
        if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0) {
            $this->pdModel->disabilitaArticolo(intval($id));
            header("Location: " . URL . "gestionePizzeria/home");
        }
    }

}
