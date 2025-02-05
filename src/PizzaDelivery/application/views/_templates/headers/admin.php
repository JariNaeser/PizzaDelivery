<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="author" content="Jari Naeser">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>PizzaDelivery</title>

    <!-- JQuery -->
    <script src="<?php echo URL . "application/libs/jQuery/jquery-3.4.1.min.js"?>"></script>

    <!-- Bootstrap -->
    <!-- Popper JS -->
    <script src="<?php echo URL . "application/libs/popper/popper-1.14.7.js"?>"></script>

    <!-- Latest compiled JavaScript -->
    <script src="<?php echo URL . "application/libs/bootstrap/js/bootstrap.js"?>"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo URL . "application/libs/bootstrap/css/bootstrap.css"?>">

    <!-- Font awesome -->
    <script src="<?php echo URL . "application/libs/fontawesome/js/all.js"?>"></script>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo URL . "css/style.css"?>">

    <!-- Mapbox -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css' rel='stylesheet' />

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <a class="navbar-brand text-truncate" id="text-holder" href="<?php echo URL?>home/index">PizzaDelivery<span id='userTypeText'><?php if(isset($_SESSION['user'])){echo " • " . $_SESSION['user'][0]['tipoUtente'] . "";}?></span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="dropdownButton">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="justify-content-end collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo URL?>home/index">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo URL ?>ordina/home">Ordina</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo URL ?>ordinazioni/home">Ordinazioni</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo URL ?>consegne/home">Consegne</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo URL ?>fattorini/home">Fattorini</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo URL ?>gestionePizzeria/home">Gestione Pizzeria</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo URL ?>login/logout">Logout</a>
            </li>
        </ul>
    </div>
</nav>

