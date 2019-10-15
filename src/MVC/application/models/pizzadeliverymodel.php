<?php

require_once 'database.php';
require_once 'validator.php';

class PizzaDeliveryModel
{
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

    public function execQuery(string $query){
        try{
            if(isset($this->connection)){
                $query = $this->validator->validateString($query);
                $tmp = $this->connection->prepare($query);
                $tmp->execute();
                return $tmp->fetchAll(PDO::FETCH_ASSOC);
            }else{
                header("Location: " . URL . "errorController/requireQueryError");
            }
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . URL . "errorController/requireQueryError");
        }
    }

    public function insertQuery(string $query){
        try{
            if(isset($this->connection)){
                $query = $this->validator->validateString($query);
                $tmp = $this->connection->prepare($query);
                $tmp->execute();
                return $this->connection->lastInsertId();
            }else{
                header("Location: " . URL . "errorController/requireQueryError");
            }
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . URL . "errorController/requireQueryError");
        }
    }

    public function getUtenti(){
        return $this->execQuery("SELECT * FROM utente;");
    }

    public function getUser(string $username){
        return $this->execQuery("SELECT * FROM utente WHERE username = '$username';");
    }

    public function getArticoli(){
        return $this->execQuery("SELECT * FROM articolo;");
    }

    public function getArticoliKey(){
        return $this->execQueryKey("SELECT * FROM articolo;");
    }

    public function getArticoliOrdinati(){
        return $this->execQuery("SELECT * FROM articolo ORDER BY nome;");
    }

    public function getArticolo($id){
        return $this->execQuery("SELECT * FROM articolo WHERE id = $id;");
    }

    public function getUserTypes(){
        return $this->execQuery("SELECT DISTINCT nome FROM TipoUtente;");
    }

    public function getPreparedOrdinazioni(){
        $arr = array();
        $ordinazioni = $this->execQuery("SELECT * FROM Ordinazione;");
        foreach ($ordinazioni as $ordine){
            $tmp = array();
            array_push($tmp, $ordine);
            $elementiOrdinati = $this->execQuery("SELECT * from OrdineArticolo WHERE ordinazione = " . $ordine['id'] . ";");
            foreach ($elementiOrdinati as $elemOrdinato){
                array_push($tmp, $elemOrdinato);
            }
            array_push($arr, $tmp);
        }
        return $arr;
    }

    public function getOrdine($id){
        $arr = array();
        $ordinazione = $this->execQuery("SELECT * FROM Ordinazione WHERE id = $id;");
        $elementi = $this->execQuery("SELECT * from OrdineArticolo WHERE ordinazione = $id;");
        array_push($arr, $ordinazione);
        array_push($arr, $elementi);
        return $arr;
    }

    public function getFattorini(){
        $fattorini = $this->execQuery("SELECT * FROM Fattorino;");
        for($i = 0; $i < count($fattorini); $i++){
            $fattorini[$i]['consegneOggi'] = $this->getConsegneOggi($fattorini[$i]['username'])[0]['COUNT(*)'];
        }
        return $fattorini;
    }

    public function getConsegneOggi(string $username){
        return $this->execQuery("SELECT COUNT(*) FROM Consegna WHERE fattorino LIKE '$username' AND CURRENT_DATE() LIKE CONCAT(YEAR(data), '-', MONTH(data), '-', DAY(data));");
    }

    public function dropArticolo(int $id){
        return $this->insertQuery("DELETE FROM articolo WHERE id = $id;");
    }

    public function dropUser(string $username){
        $this->insertQuery("DELETE FROM fattorino WHERE username = '$username';");
        $this->insertQuery("DELETE FROM utente WHERE username = '$username';");
    }

    public function addToCart(int $id){
        if(isset($_SESSION['cart']) && is_int($id)){
            $item = $this->pdModel->getArticolo($id);
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

}