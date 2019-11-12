<?php
/**
 * Created by PhpStorm.
 * User: jarinaser
 * Date: 12.11.19
 * Time: 13:28
 */

require_once 'database.php';
require_once 'validator.php';

class ConsegneModel{

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

    /**
     * Metodo privato usato solamente in casi necessari nel quale il filtraggio della query potrebbe
     * corrompere il suo corretto funzionamento come ad esempio la seguente istruzione che
     * da così: SELECT nome FROM Esempio WHERE eta < 5;
     * a così: SELECT nome FROM Esempio WHERE eta &lt; 5;
     *
     * @param string $query
     * @return array
     */
    private function execQueryWithoutValidating(string $query){
        try{
            if(isset($this->connection)){
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

    public function getConsegneConData($number){
        if(!is_int($number)){
            $number = intval($number);
        }
        switch ($number){
            case 1:
                return $this->execQueryWithoutValidating("SELECT * FROM CONSEGNA WHERE dataInserimento > DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY dataInserimento DESC;");
                break;
            case 2:
                return $this->execQueryWithoutValidating("SELECT * FROM CONSEGNA WHERE dataInserimento > DATE_SUB(NOW(), INTERVAL 2 WEEK) ORDER BY dataInserimento DESC;");
                break;
            case 3:
                return $this->execQueryWithoutValidating("SELECT * FROM CONSEGNA WHERE dataInserimento > DATE_SUB(NOW(), INTERVAL 3 WEEK) ORDER BY dataInserimento DESC;");
                break;
            case 4:
                return $this->execQueryWithoutValidating("SELECT * FROM CONSEGNA WHERE dataInserimento > DATE_SUB(NOW(), INTERVAL 4 WEEK) ORDER BY dataInserimento DESC;");
                break;
            case 24:
                return $this->execQueryWithoutValidating("SELECT * FROM CONSEGNA WHERE dataInserimento > DATE_SUB(NOW(), INTERVAL 24 WEEK) ORDER BY dataInserimento DESC;");
                break;
            case 10000:
                return $this->execQuery("SELECT * FROM CONSEGNA ORDER BY dataInserimento DESC;");
                break;
            default:
                return $this->execQuery("SELECT * FROM CONSEGNA ORDER BY dataInserimento DESC;");
                break;
        }
    }

    public function setConsegnaDaEffettuare(int $id){
        $this->insertQuery("UPDATE Consegna SET tipoConsegna = 'da effettuare', dataConsegna = null WHERE id = $id AND tipoConsegna NOT LIKE 'da effettuare';");
    }

    public function setConsegnaInCorso(int $id){
        $this->insertQuery("UPDATE Consegna SET tipoConsegna = 'in corso', dataConsegna = null WHERE id = $id AND tipoConsegna NOT LIKE 'in corso';");
    }

    public function setConsegnaTerminata(int $id){
        $this->insertQuery("UPDATE Consegna SET tipoConsegna = 'terminata', dataConsegna = now() WHERE id = $id AND tipoConsegna NOT LIKE 'terminata';");
    }

}