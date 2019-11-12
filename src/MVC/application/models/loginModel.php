<?php
/**
 * Created by PhpStorm.
 * User: jarinaser
 * Date: 12.11.19
 * Time: 13:29
 */

require_once 'database.php';
require_once 'validator.php';

class LoginModel{

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
            $query = $this->validator->validateString($query);
            $tmp = $this->connection->prepare($query);
            $tmp->execute();
            return $tmp->fetchAll(PDO::FETCH_ASSOC);
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

}