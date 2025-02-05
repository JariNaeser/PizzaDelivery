<?php

/**
 * Configurazione
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */

/**
 * Configurazione di : Error reporting
 * Utile per vedere tutti i piccoli problemi in fase di sviluppo, in produzione solo quelli gravi
 */
error_reporting(0);
ini_set("display_errors", 0);

/**
 * Configurazione di : URL del progetto
 */
define('URL', 'http://localhost:8888/php/Progetti/PizzaDelivery/src/PizzaDelivery/');

