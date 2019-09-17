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
        return mysqli_fetch_all($this->connection->query($query));
    }
}