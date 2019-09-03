<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        *{
            font-family: Helvetica;
            text-align: center;
        }

        h1{
            margin-bottom: 0px;
        }

        p{
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div>
        <h1>Login</h1>
        <p>Registrati per poter Visualizzare tutti i prestiti.</p>
        <form action="<?php echo URL ?>home/login" method="post">
            <input type="text" placeholder="Username" name="username"><br>
            <input type="password" placeholder="Password" name="password"><br>
            <button type="submit">Login</button>
        </form>
        <br>
    </div>
</div>
</body>