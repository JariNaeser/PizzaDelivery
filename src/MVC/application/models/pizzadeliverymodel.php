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
                die("ERROR: Impossibile creare una connessione con il Database. \n");
            }
        }
    }

    public function execQuery(string $query){
        if(isset($this->connection)){
            $query = htmlspecialchars($query);
            $query = stripslashes($query);
            $tmp = $this->connection->prepare($query);
            $tmp->execute();
            return $tmp->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return ERROR_MESSAGE;
        }
    }
}