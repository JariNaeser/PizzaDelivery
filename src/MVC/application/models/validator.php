<?php
/**
 * Created by PhpStorm.
 * User: jarinaser
 * Date: 10.10.19
 * Time: 15:18
 */

class Validator
{

    //private $regex;

    public function __construct(){
        //$this->regex = "/A-Za-z0-9àèìòùÀÈÌÒÙäöüÖÄÜéÉ/@.,/";
    }

    private function validateInput(string $text){
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);

        return $text;
    }

    public function validateInt(string $text){
        return intval($this->validateInput($text));
    }

    public function validateString(string $text){
        return $this->validateInput($text);
    }

}