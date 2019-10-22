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
            $fattorini[$i]['consegneOggi'] = $this->getConsegneOggi($fattorini[$i]['username'])[0]['consegneOggi'];
        }
        return $fattorini;
    }

    public function getConsegneOggi(string $username){
        return $this->execQuery("SELECT COUNT(*) AS 'consegneOggi' FROM Consegna WHERE fattorino LIKE '$username' AND tipoConsegna LIKE 'terminata' AND CURRENT_DATE() LIKE CONCAT(YEAR(dataInserimento), '-', MONTH(dataInserimento), '-', DAY(dataInserimento));");
    }

    public function getFattorino(string $username){
        $fattorino = $this->execQuery("SELECT * FROM Fattorino WHERE username LIKE '$username';");
        $fattorino['consegneOggi'] = $this->getConsegneOggi($username)[0]['consegneOggi'];
        return $fattorino;
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

    public function getFattoriniOrdinatiENon(){
        return $this->execQuery("SELECT username, inServizio FROM Fattorino ORDER BY inServizio");
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
            $item = $this->getArticolo($id);
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