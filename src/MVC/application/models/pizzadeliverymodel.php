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
            header("Location: " . PAGES . "requireQueryError");
        }
    }

    public function getUtenti(){
        return $this->execQuery("SELECT * FROM utente;");
    }

    public function getUser(string $username){
        return $this->execQuery("SELECT * FROM utente WHERE username = $username;");
    }

    public function getArticoli(){
        return $this->execQuery("SELECT * FROM articolo;");
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

}