<?php

require_once 'rightHeader.php';

class Ordinazioni
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

        $_SESSION['ordine'] = $this->pdModel->getOrdine($id);
        $_SESSION['articoli'] = $this->pdModel->getArticoli();

        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/ordinazioni/ordinazione.php';
        require 'application/views/_templates/footer.php';
    }

    public function assegnaAFattorino(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['selezioneFattorino']) && isset($_POST['nrOrdine'])){
                $fattorino = $_POST['selezioneFattorino'];
                $nrOrdine = $_POST['nrOrdine'];

                $this->pdModel->insertQuery("INSERT INTO Consegna(tipoConsegna, fattorino, ordinazione) VALUES ('da effettuare', '$fattorino', $nrOrdine);");
                $this->pdModel->insertQuery("UPDATE Ordinazione SET prontaPerConsegna = 1 WHERE id = $nrOrdine");

                //Redirect alla home
                header("Location: " . URL . "ordinazioni/home");
                $this->home();

            }else{
                header("Location: " . URL . "errorController/assegnaAFattorinoError");
            }
        }else{
            header("Location: " . URL . "errorController/assegnaAFattorinoError");
        }
    }

}
