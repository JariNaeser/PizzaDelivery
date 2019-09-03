<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Failed</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        *{
            font-family: Helvetica;
            text-align: center;
        }
        red{
            color: red;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <h1><red>ERRORE</red>: L'utente immesso nel login non è registrato nel sistema.</h1>
        <p>Immetti l'utente correttamente e torna alla <a href="<?php echo URL . 'home/views/home/' ?>">home</a>.</p>
    </div>
</nav>
</body>
</html>