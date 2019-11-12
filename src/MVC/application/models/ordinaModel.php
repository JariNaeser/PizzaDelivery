<?php
/**
 * Created by PhpStorm.
 * User: jarinaser
 * Date: 12.11.19
 * Time: 13:30
 */

require_once 'database.php';
require_once 'validator.php';

class OrdinaModel{

    //Lavora con il DB.
    private $connection;

    //Oggetto Validator per le validazioni dei campi di input.
    private $validator;

    public function __construct(){
        if(!isset($this->connection)){
            try{
                $this->validator = new Validator();
                $this->connection = Database::getConnection();
            }catch(PDOException $e){
                header("Location: " . URL . "errorController/requireConnectionError");
            }
        }
    }

    /**
     * Metodo execQuery che si occupa di ricevere una query come parametro senza dover fare nessun
     * bind, la esegue e ritorna il risultato di essa.
     *
     * @param string $query Query da eseguire.
     * @return array Risultato della query eseguita.
     */
    public function execQuery(string $query){
        try{
            $query = $this->validator->validateString($query);
            $tmp = $this->connection->prepare($query);
            $tmp->execute();
            return $tmp->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . URL . "errorController/requireQueryError");
        }
    }

    public function getArticoliOrdinati(){
        return $this->execQuery("SELECT * FROM articolo ORDER BY nome;");
    }

    public function insertOrdinazione(string $nome, string $cognome, int $numeroTelefono, string $via, int $cap, string $paese){
        //Controllo
        $nome = $this->validator->validateString($nome);
        $cognome = $this->validator->validateString($cognome);
        $numeroTelefono = $this->validator->validateInt($numeroTelefono);
        $via = $this->validator->validateString($via);
        $cap = $this->validator->validateInt($cap);
        $paese = $this->validator->validateString($paese);

        //Query
        try{
            $tmp = $this->connection->prepare("INSERT INTO Ordinazione(nomeCliente, cognomeCliente, numeroTelefonoCliente, via, cap, paese) VALUES (:nome, :cognome, :numeroTelefono, :via, :cap, :paese);");
            $tmp->bindParam(":nome", $nome);
            $tmp->bindParam(":cognome", $cognome);
            $tmp->bindParam(":numeroTelefono", $numeroTelefono);
            $tmp->bindParam(":via", $via);
            $tmp->bindParam(":cap", $cap);
            $tmp->bindParam(":paese", $paese);
            $tmp->execute();
            return $this->connection->lastInsertId();
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . URL . "errorController/requireQueryError");
        }
    }

    public function insertOrdineArticolo(int $ordinazione, int $articolo, int $quantita){
        //Controllo
        $ordinazione = $this->validator->validateInt($ordinazione);
        $articolo = $this->validator->validateInt($articolo);
        $quantita = $this->validator->validateInt($quantita);

        //Query
        try{
            $tmp = $this->connection->prepare("INSERT INTO OrdineArticolo VALUES (:ordinazione, :articolo, :quantita);");
            $tmp->bindParam(":ordinazione", $ordinazione);
            $tmp->bindParam(":articolo", $articolo);
            $tmp->bindParam(":quantita", $quantita);
            $tmp->execute();
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . URL . "errorController/requireQueryError");
        }
    }

    public function addToCart(int $id){
        if(isset($_SESSION['cart']) && is_int($id)){
            $item = $this->getArticolo($id);
            if(!in_array($item, $_SESSION['cart'])){
                array_push($_SESSION['cart'], $item);
            }
        }
    }

    public function removeFromcart(int $id){
        if(isset($_SESSION['cart'])){
            $arr = array();
            foreach($_SESSION['cart'] as $element){
                if($element[0]['id'] != $id){
                    array_push($arr, $element);
                }
            }
            $_SESSION['cart'] = $arr;
        }
    }

    public function getArticolo($id){
        return $this->execQuery("SELECT * FROM articolo WHERE id = $id;");
    }

}