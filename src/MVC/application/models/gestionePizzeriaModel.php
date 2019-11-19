<?php
/**
 * Created by PhpStorm.
 * User: jarinaser
 * Date: 12.11.19
 * Time: 13:29
 */

require_once 'database.php';
require_once 'validator.php';

class GestionePizzeriaModel{

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

    public function getUserTypes(){
        return $this->execQuery("SELECT DISTINCT nome FROM TipoUtente;");
    }

    public function getUtenti(){
        return $this->execQuery("SELECT * FROM utente;");
    }

    public function getArticoliOrdinati(){
        return $this->execQuery("SELECT * FROM articolo ORDER BY nome;");
    }

    public function getUser(string $username){
        return $this->execQuery("SELECT * FROM utente WHERE username = '$username';");
    }

    public function updateUtente(string $username, string $nome, string $cognome, string $via, int $cap, string $paese, string $email, string $password, string $tipologia){

        //Controllo
        $username = $this->validator->validateString(strtolower($username));
        $nome = $this->validator->validateString(strtolower($nome));
        $cognome = $this->validator->validateString(strtolower($cognome));
        $via = $this->validator->validateString($via);
        $cap = $this->validator->validateInt($cap);
        $paese = $this->validator->validateString($paese);
        $email = $this->validator->validateString($email);
        $password = $this->validator->validateString($password);
        $tipologia = $this->validator->validateString($tipologia);

        //Query
        try{
            $tmp = $this->connection->prepare("UPDATE utente SET nome= :nome, cognome= :cognome, via= :via, cap= :cap, paese= :paese, email= :email, password= :password, tipoUtente= :tipoUtente WHERE username LIKE :username;");
            $tmp->bindParam(":nome", $nome);
            $tmp->bindParam(":cognome", $cognome);
            $tmp->bindParam(":via", $via);
            $tmp->bindParam(":cap", $cap);
            $tmp->bindParam(":paese", $paese);
            $tmp->bindParam(":email", $email);
            $tmp->bindParam(":password", $password);
            $tmp->bindParam(":tipoUtente", $tipologia);
            $tmp->bindParam(":username", $username);
            $tmp->execute();
            return $tmp->queryString;
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . URL . "errorController/requireQueryError");
        }
    }

    public function dropUser(string $username){
        $user = $this->getUser($username);
        if(strcmp($user[0]['tipoUtente'], 'amministratore') == 0 && $this->execQuery("SELECT COUNT(username) AS 'numAdmin' FROM utente WHERE tipoUtente LIKE 'amministratore';")[0]['numAdmin'] <= 1){
            return "ERRORE";
        }else{
            $this->insertQuery("DELETE FROM utente WHERE username = '$username';");
        }
    }

    public function insertUtente(string $nome, string $cognome, string $via, int $cap, string $paese, string $email, string $password, string $tipologia){
        //Controllo
        $nome = $this->validator->validateString(strtolower($nome));
        $cognome = $this->validator->validateString(strtolower($cognome));
        $via = $this->validator->validateString($via);
        $cap = $this->validator->validateInt($cap);
        $paese = $this->validator->validateString($paese);
        $email = $this->validator->validateString($email);
        $password = hash('sha256', $this->validator->validateString($password));
        $tipologia = $this->validator->validateString($tipologia);

        $username = $nome . "." . $cognome;

        //Check if this username already exists
        $tmp = $this->execQuery("SELECT COUNT(*) AS 'numeroUsernameUguale' FROM Utente WHERE username LIKE '$username';");
        if($tmp[0]['numeroUsernameUguale'] != 0){
            $selectUsernames = $this->execQuery("SELECT COUNT(*) AS 'countUsers' FROM Utente WHERE username LIKE '$username%';");
            $username .= $selectUsernames[0]['countUsers']++;
        }

        //Query
        try{
            $tmp = $this->connection->prepare("INSERT INTO utente VALUES (:username, :nome, :cognome, :via, :cap, :paese, :email, :password, :tipoUtente);");
            $tmp->bindParam(":nome", $nome);
            $tmp->bindParam(":cognome", $cognome);
            $tmp->bindParam(":via", $via);
            $tmp->bindParam(":cap", $cap);
            $tmp->bindParam(":paese", $paese);
            $tmp->bindParam(":email", $email);
            $tmp->bindParam(":password", $password);
            $tmp->bindParam(":tipoUtente", $tipologia);
            $tmp->bindParam(":username", $username);
            $tmp->execute();
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . URL . "errorController/requireQueryError");
        }
    }

    public function getArticolo($id){
        return $this->execQuery("SELECT * FROM articolo WHERE id = $id;");
    }

    public function updateArticolo(string $nome, string $descrizione, float $prezzo, string $path, int $id){
        //Controllo
        $nome = $this->validator->validateString($nome);
        $descrizione = $this->validator->validateString($descrizione);
        $prezzo = $this->validator->validateDouble($prezzo);
        $path = $this->validator->validateString($path);
        $id = $this->validator->validateInt($id);

        //Query
        try{
            $tmp = $this->connection->prepare("UPDATE articolo SET nome= :nome, descrizione= :descrizione, prezzo= :prezzo, urlFoto= :urlFoto WHERE id = :id;");
            $tmp->bindParam(":nome", $nome);
            $tmp->bindParam(":descrizione", $descrizione);
            $tmp->bindParam(":prezzo", $prezzo);
            $tmp->bindParam(":urlFoto", $path);
            $tmp->bindParam(":id", $id);
            $tmp->execute();
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . URL . "errorController/requireQueryError");
        }
    }

    public function insertArticolo(string $nome, string $descrizione, float $prezzo, $path){
        //Controllo
        $nome = $this->validator->validateString($nome);
        $descrizione = $this->validator->validateString($descrizione);
        $prezzo = $this->validator->validateDouble($prezzo);
        if(isset($path)){
            $path = $this->validator->validateString($path);
        }

        //Query
        try{
            if(isset($path)){
                $tmp = $this->connection->prepare("INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES (:nome, :descrizione, :prezzo, :urlFoto);");
                $tmp->bindParam(":urlFoto", $path);
            }else{
                $tmp = $this->connection->prepare("INSERT INTO Articolo(nome, descrizione, prezzo) VALUES (:nome, :descrizione, :prezzo);");
            }
            $tmp->bindParam(":nome", $nome);
            $tmp->bindParam(":descrizione", $descrizione);
            $tmp->bindParam(":prezzo", $prezzo);
            $tmp->execute();
        }catch(PDOException $e){
            $_SESSION['queryError'] = $e->getMessage();
            header("Location: " . URL . "errorController/requireQueryError");
        }
    }

    public function dropArticolo(int $id){
        return $this->insertQuery("DELETE FROM articolo WHERE id = $id;");
    }

}