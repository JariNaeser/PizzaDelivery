<?php
/**
 * Created by PhpStorm.
 * User: jarinaser
 * Date: 10.04.19
 * Time: 10:41
 */

class UtentiModel
{
    public function getUsers(){
        $filename = "application/data/utenti.csv";
        $contents = file($filename);
        return $contents;
    }

    public function getBooks(){
        $filename = "application/data/libri.csv";
        $contents = file($filename);
        return $contents;
    }

    public function getLendings(){
        $filename = "application/data/prestiti.csv";
        $contents = file($filename);
        return $contents;
    }

    public function login(){
        $foundUser = false;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['username']) && isset($_POST['password'])){
                $username = $_POST['username'];
                $password = $_POST['password'];
                $users = $this->getUsers();
                foreach ($users as $user){
                    $splitted = explode(',', $user);
                    if($splitted[2] == $username && $splitted[3] == $password){
                        $foundUser = true;
                        session_start();
                        $_SESSION['formattedTable'] = $this->getFormattedTable();
                        $_SESSION['username'] = $_POST['username'];
                        if(isset($_COOKIE[$username]) && isset($_COOKIE[$username . 'Value'])){
                            $this->setCookie($username, $_COOKIE[$username . 'Value']++);
                        }else{
                            $this->setCookie($username, 0);
                        }
                        print_r($_COOKIE);
                        require 'application/views/prestiti/index.php';
                    }
                }
            }
        }
        if(!$foundUser){
            require 'application/views/_templates/loginFailed.php';
        }
    }

    public function removeHeader($array){
        $arr = array();
        for($i = 1; $i < count($array); $i++){
            array_push($arr, $array[$i]);
        }
        return $arr;
    }

    public function getFormattedTable(){
        $utenti = $this->removeHeader($this->getUsers());
        $libri = $this->removeHeader($this->getBooks());
        $prestiti = $this->removeHeader($this->getLendings());
        $isbnFound = false;
        $usernameFound = false;

        $array = array();
        array_push($array,
            array(
                'Titolo',
                'Autore',
                'Editore',
                'Anno',
                'Nome e cognome Cliente',
                'Indirizzo completo cliente',
                'Prestato il',
                'Ritorno il'
            )
        );

        foreach($prestiti as $prestito){
            $prestito = explode(',', $prestito);
            if(count($prestito) == 4){
                $isbn = $prestito[0];
                $username = $prestito[1];
                $prestato = $prestito[2];
                $restituito = $prestito[3];

                //Check for isbn
                foreach ($libri as $libro){
                    $libro = explode(',', $libro);
                    if(strcmp($libro[0], $isbn)){
                        $isbnFound = true;
                        $isbnRow = $libro;
                        break;
                    }
                }

                //Check for username
                foreach ($utenti as $utente){
                    $utente = explode(',', $utente);
                    if(strcmp($utente[2], $username)){
                        $usernameFound = true;
                        $usernameRow = $utente;
                        break;
                    }
                }

                if(($isbnFound && $usernameFound)&&(isset($isbnRow) && isset($usernameRow))){
                    $arr = array(
                        $isbnRow[1],
                        $isbnRow[2],
                        $isbnRow[4],
                        $isbnRow[3],
                        $usernameRow[0] . " " . $usernameRow[1],
                        $usernameRow[4],
                        $prestito[2],
                        $prestito[3]
                    );
                    array_push($array, $arr);
                }
            }
        }

        return $array;

    }

    public function setCookie($username, $value){
        echo $value;
        if(!is_numeric($value)){
            $value = (int)$value;
        }
        if($value == 0 || $value == 11){
            $cookie_value = "Benvenuto " . $username;
        }elseif($value >= 2 && $value < 6){
            $cookie_value = "Bentornato " . $username . ", sei alla " . $value . " visita";
        }elseif($value >= 6 && $value < 11){
            $cookie_value = "Ci sembra che tu stia incontrando dei problemi ad accedere al nostro sito, " . $username
                . ". Sei già alla visita numero " . $value;
        }
        setcookie($username, $cookie_value, time() + (86400 * 30), "/");
        setcookie($username . 'Value', $value, time() + (86400 * 30), "/");
    }
}