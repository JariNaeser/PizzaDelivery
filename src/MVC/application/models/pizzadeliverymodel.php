<?php

require_once 'database.php';

class PizzaDeliveryModel
{
    //Lavora con il DB.
    private $connection;

    public function __construct(){
        if(!isset($this->connection)){
            try{
                $this->connection = Database::getConnection();
            }catch(PDOException $e){
                header("Location: " . PAGES . "requireConnectionError");
            }
        }
    }

    public function execQuery(string $query){
        try{
            if(isset($this->connection)){
                $query = $this->sanitizeInput($query);
                $tmp = $this->connection->prepare($query);
                $tmp->execute();
                return $tmp->fetchAll(PDO::FETCH_ASSOC);
            }else{
                header("Location: " . PAGES . "requireQueryError");
            }
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . PAGES . "requireQueryError");
        }
    }

    public function insertQuery(string $query){
        try{
            if(isset($this->connection)){
                $query = $this->sanitizeInput($query);
                $tmp = $this->connection->prepare($query);
                $tmp->execute();
                return $this->connection->lastInsertId();
            }else{
                header("Location: " . PAGES . "requireQueryError");
            }
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . PAGES . "requireQueryError");
        }
    }

    public function getUtenti(){
        return $this->execQuery("SELECT * FROM utente;");
    }

    public function getUser(string $username){
        return $this->execQuery("SELECT * FROM utente WHERE username = '$username';");
    }

    public function dropUser(string $username){
        return $this->insertQuery("DELETE FROM utente WHERE username = '$username';");
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

    private function sanitizeInput(string $query){
        $query = htmlspecialchars($query);
        $query = stripslashes($query);
        return $query;
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

}