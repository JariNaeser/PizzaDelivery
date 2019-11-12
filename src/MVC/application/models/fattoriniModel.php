<?php
/**
 * Created by PhpStorm.
 * User: jarinaser
 * Date: 12.11.19
 * Time: 13:28
 */

require_once 'database.php';
require_once 'validator.php';

class FattoriniModel{

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

    public function getConsegne(string $username){
        $consegne = $this->execQuery("SELECT * FROM Consegna WHERE fattorino LIKE '$username' AND CONCAT(YEAR(dataInserimento),'-', MONTH(dataInserimento),'-', DAY(dataInserimento)) LIKE CURRENT_DATE()");
        for($i = 0; $i < count($consegne); $i++){
            //Get via
            $consegne[$i]['via'] = $this->execQuery("SELECT via FROM Ordinazione WHERE id = (SELECT ordinazione FROM Consegna WHERE id = " . $consegne[$i]['id'] . ");");
            //Get totalCost
            $consegne[$i]['costoTotale'] = $this->execQuery("SELECT SUM((SELECT prezzo FROM Articolo WHERE id = articolo) * quantita) AS 'SommaCosti'
                                                                    FROM OrdineArticolo o WHERE ordinazione = (
                                                                    SELECT ordinazione FROM Consegna c, Fattorino f
                                                                    WHERE c.fattorino LIKE f.username AND tipoConsegna LIKE 'terminata' AND id = " . $consegne[$i]['id'] . ");
                                                           ");
        }
        return $consegne;
    }

    public function getUser(string $username){
        return $this->execQuery("SELECT * FROM utente WHERE username = '$username';");
    }

    public function getFattorini(){
        $fattorini = $this->execQuery("SELECT * FROM Fattorino;");
        for($i = 0; $i < count($fattorini); $i++){
            $fattorini[$i]['consegneOggi'] = $this->getConsegneOggi($fattorini[$i]['username'])[0]['consegneOggi'];
        }
        return $fattorini;
    }

    public function getFattorino(string $username){
        $fattorino = $this->execQuery("SELECT * FROM Fattorino WHERE username LIKE '$username';");
        $fattorino['consegneOggi'] = $this->getConsegneOggi($username)[0]['consegneOggi'];
        return $fattorino;
    }

    public function getConsegneOggi(string $username){
        return $this->execQuery("SELECT COUNT(*) AS 'consegneOggi' FROM Consegna WHERE fattorino LIKE '$username' AND tipoConsegna LIKE 'terminata' AND CURRENT_DATE() LIKE CONCAT(YEAR(dataInserimento), '-', MONTH(dataInserimento), '-', DAY(dataInserimento));");
    }

}