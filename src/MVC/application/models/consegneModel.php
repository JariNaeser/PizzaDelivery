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

    /**
     * Metodo insertQuery che si occupa di ricevere una query come parametro senza dover fare nessun
     * bind, la esegue e ritorna l'ultimo id inserito.
     *
     * @param string $query Query da eseguire.
     * @return string Ultimo id inserito.
     */
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

    /**
     * Metodo che ritorna tutte le consegne da oggi fino a x settimane (impostate con $number).
     *
     * @param $number Numero di settimane da usare.
     * @return array Consegne da oggi a $number settimane fa.
     */
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
            default: //Also if case 10000
                return $this->execQuery("SELECT * FROM CONSEGNA ORDER BY dataInserimento DESC;");
                break;
        }
    }

    /**
     * Metodo che setta una consegna da effettuare.
     *
     * @param int $id Chiave della consegna da modificare.
     */
    public function setConsegnaDaEffettuare(int $id){
        $this->insertQuery("UPDATE Consegna SET tipoConsegna = 'da effettuare', dataConsegna = null WHERE id = $id AND tipoConsegna NOT LIKE 'da effettuare';");
    }

    /**
     * Metodo che setta una consegna in corso.
     *
     * @param int $id Chiave della consegna da modificare.
     */
    public function setConsegnaInCorso(int $id){
        $this->insertQuery("UPDATE Consegna SET tipoConsegna = 'in corso', dataConsegna = null WHERE id = $id AND tipoConsegna NOT LIKE 'in corso';");
    }

    /**
     * Metodo che setta una consegna terminata.
     *
     * @param int $id Chiave della consegna da modificare.
     */
    public function setConsegnaTerminata(int $id){
        $this->insertQuery("UPDATE Consegna SET tipoConsegna = 'terminata', dataConsegna = now() WHERE id = $id AND tipoConsegna NOT LIKE 'terminata';");
    }

}