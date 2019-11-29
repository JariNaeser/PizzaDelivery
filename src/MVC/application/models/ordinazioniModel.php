<?php
/**
 * Created by PhpStorm.
 * User: jarinaser
 * Date: 12.11.19
 * Time: 13:30
 */

require_once 'database.php';
require_once 'validator.php';

class OrdinazioniModel{

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

    public function getFattoriniOrdinatiENon(){
        return $this->execQuery("SELECT f.username, f.inServizio 
                                        FROM Fattorino f JOIN utente u ON u.username = f.username 
                                        WHERE u.utenteAbilitato = 1 ORDER BY f.inServizio;
                                ");
    }

    public function getArticoli(){
        return $this->execQuery("SELECT * FROM articolo;");
    }

    public function insertConsegna(string $tipoConsegna, string $fattorino, int $ordinazione){
        //Controllo
        $tipoConsegna = $this->validator->validateString($tipoConsegna);
        $fattorino = $this->validator->validateString($fattorino);
        $ordinazione = $this->validator->validateInt($ordinazione);

        //Query
        try{
            $tmp = $this->connection->prepare("INSERT INTO Consegna(tipoConsegna, fattorino, ordinazione) VALUES (:tipoConsegna, :fattorino, :ordinazione);");
            $tmp->bindParam(":tipoConsegna", $tipoConsegna);
            $tmp->bindParam(":fattorino", $fattorino);
            $tmp->bindParam(":ordinazione", $ordinazione);
            $tmp->execute();
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . URL . "errorController/requireQueryError");
        }
    }

    public function updateOrdinazionePPC(int $nrOrdine){
        //Controllo
        $nrOrdine = $this->validator->validateInt($nrOrdine);

        //Query
        try{
            $tmp = $this->connection->prepare("UPDATE Ordinazione SET prontaPerConsegna = 1 WHERE id = :nrOrdine;");
            $tmp->bindParam(":nrOrdine", $nrOrdine);
            $tmp->execute();
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . URL . "errorController/requireQueryError");
        }
    }

    public function eliminaOrdinazione(int $id){
        //Controllo
        $id = $this->validator->validateInt($id);
        //Query
        try{
            $tmp = $this->connection->prepare("DELETE FROM Ordinazione WHERE id = :id;");
            $tmp->bindParam(":id", $id);
            $tmp->execute();
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . URL . "errorController/requireQueryError");
        }
    }

    public function setFattorinoLibero(string $username){
        $this->insertQuery("UPDATE fattorino SET inServizio = 0 WHERE username LIKE '$username';");
    }

    public function setFattorinoOccupato(string $username){
        $this->insertQuery("UPDATE fattorino SET inServizio = 1 WHERE username LIKE '$username';");
    }

}