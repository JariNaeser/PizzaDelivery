<?php

require_once 'database.php';

class PizzaDeliveryModel
{
    //Lavora con il DB.
    private $connection;

    public function __construct(){
        if(!isset($this->connection)){
            $this->connection = Database::getConnection();
        }
    }

    public function execQuery(string $query){
        $tmp = $this->connection->prepare($query);
        $tmp->execute();
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }
}