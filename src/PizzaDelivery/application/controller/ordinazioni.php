<?php

require_once 'rightHeader.php';

class Ordinazioni
{

    private $pdModel;
    private $header;

    public function __construct()
    {
        if(file_exists('application/models/ordinazioniModel.php')){
            require_once 'application/models/ordinazioniModel.php';
            $this->pdModel = new OrdinazioniModel();
            $this->header = new RightHeader();
            session_start();
        }else{
            exit("ERRORE nel costruttore della classe ordinazioni dei controller.");
        }
    }

    public function home(){

        $_SESSION['ordinazioni'] = $this->pdModel->getPreparedOrdinazioni();
        $_SESSION['fattoriniOrdinatiLiberiENon'] = $this->pdModel->getFattoriniOrdinatiENon();

        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/ordinazioni/ordinazioni.php';
        require 'application/views/_templates/footer.php';
    }

    public function ordinazione(int $id){
        if(isset($_SESSION['user']) && (strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0 || strcmp($_SESSION['user'][0]['tipoUtente'], 'impiegato vendita') == 0)) {
            $_SESSION['ordine'] = $this->pdModel->getOrdine($id);
            $_SESSION['articoli'] = $this->pdModel->getArticoli();

            // Carico Views
            $this->header->getRightHeader();
            require 'application/views/pages/ordinazioni/ordinazione.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function assegnaAFattorino(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_SESSION['user']) && (strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0 || strcmp($_SESSION['user'][0]['tipoUtente'], 'impiegato vendita') == 0)) {
                if (isset($_POST['selezioneFattorino']) && isset($_POST['nrOrdine'])) {
                    $fattorino = $_POST['selezioneFattorino'];
                    $nrOrdine = $_POST['nrOrdine'];

                    $this->pdModel->insertConsegna(
                        'da effettuare',
                        $fattorino,
                        $nrOrdine
                    );

                    $this->pdModel->updateOrdinazionePPC(
                        $nrOrdine
                    );

                    $this->pdModel->setFattorinoOccupato($fattorino);

                    //Redirect alla home
                    header("Location: " . URL . "ordinazioni/home");
                    $this->home();

                } else {
                    header("Location: " . URL . "errorController/assegnaAFattorinoError");
                }
            }
        }else{
            header("Location: " . URL . "errorController/assegnaAFattorinoError");
        }
    }

    public function eliminaOrdinazione(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_SESSION['user']) && (strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0 || strcmp($_SESSION['user'][0]['tipoUtente'], 'impiegato vendita') == 0)) {
                if (isset($_POST['idOrdinazione'])) {
                    echo "Value: " . $_POST['idOrdinazione'];
                    $this->pdModel->eliminaOrdinazione(intval($_POST['idOrdinazione']));
                }
            }
        }
        header("Location: " . URL . "ordinazioni/home");
    }

}
