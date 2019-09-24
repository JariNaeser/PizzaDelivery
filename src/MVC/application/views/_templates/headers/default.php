<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="author" content="Jari Naeser">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>


    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/8d7154f948.js" crossorigin="anonymous"></script>

    <style>

        body{
            width: 100%;
        }

        .padding-footer{
            padding-bottom: 44px;
        }

        .centerVerticallyDiv{
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        input{
            margin: 1em;
        }

        .items-table{
            display: block;
            max-height: 300px;
            overflow-y: scroll;
            width: 100%;
        }


    </style>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <a class="navbar-brand" href="<?php echo URL?>home/index">PizzaDelivery</a>
</nav>

