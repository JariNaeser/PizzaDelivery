<?php

require_once 'rightHeader.php';

class Ordina
{

    private $pdModel;
    private $header;

    public function __construct()
    {
        if(file_exists('application/models/ordinaModel.php')){
            require_once 'application/models/ordinaModel.php';
            $this->pdModel = new OrdinaModel();
            $this->header = new RightHeader();

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
            exit("ERRORE nel costruttore della classe ordina dei controller.");
        }
    }

    public function home(){
        $_SESSION['articoli'] = $this->pdModel->getArticoliOrdinati();
        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/ordina/ordina.php';
        require 'application/views/_templates/footer.php';

    }

    public function confermaordine(){
        // Carico Views
        $this->header->getRightHeader();
        require 'application/views/pages/ordina/confermaOrdine.php';
        require 'application/views/_templates/footer.php';
    }

    public function addToCart(int $id){
        $this->pdModel->addToCart($id);
        header("Location: " . URL . "ordina/home");
        $this->home();
    }

    public function removeFromCart(int $id){
        $this->pdModel->removeFromCart($id);
        header("Location: " . URL . "ordina/home");
        $this->home();
    }

    public function creaOrdine(){
        //Crea ordine.
        if(isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['numeroTelefono']) && isset($_POST['paese']) && isset($_POST['cap']) && isset($_POST['via']) && isset($_POST['numero']) && isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){

            $atLeastOneFound = false;

            foreach ($_SESSION['cart'] as $element){
                if($_POST['select' . $element[0]['id']] != 0){
                    //Insert into ordine
                    $id = $this->pdModel->insertOrdinazione(
                        $_POST['nome'],
                        $_POST['cognome'],
                        $_POST['numeroTelefono'],
                        ($_POST['via'] . " " . $_POST['numero']),
                        $_POST['cap'],
                        $_POST['paese']
                    );
                    $atLeastOneFound = true;
                    break;
                }
            }

            if($atLeastOneFound){
                //Insert into OrdineArticolo

                $counter = 0;

                foreach ($_SESSION['cart'] as $element){
                    if($_POST['select' . $element[0]['id']] != 0){
                        $this->pdModel->insertOrdineArticolo(
                            $id,
                            $element[0]['id'],
                            $_POST['select' . $element[0]['id']]
                        );
                        $counter++;
                    }
                }

                if($counter > 0){
                    //Se andato a buon fine
                    $this->header->getRightHeader();
                    require 'application/views/pages/ordina/ringraziamentoOrdine.php';
                    require 'application/views/_templates/footer.php';
                }else{
                    //Cart vuoto, mostra errore.
                    header("Location: " . URL . "errorController/emptyCartError");
                }
            }else{
                //Cart vuoto, mostra errore.
                header("Location: " . URL . "errorController/emptyCartError");
            }
            //Azzera contenuto carrello
            $_SESSION['cart'] = null;
        }else{
            header("Location: " . URL . "errorController/emptyCartError");
        }
    }

}
