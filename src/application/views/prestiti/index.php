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

        table {
            border-collapse: collapse;
            width: 50%;
            margin: 0px auto;
            float: none;
            overflow-x: auto;
        }
        td, th{
            border: solid 1px;
            padding: 10px;
        }

        th{
            background-color: lightgray;
        }
    </style>
</head>
<body>
<div class="container">
    <div>
        <h1>
            <?php echo $_COOKIE[$_SESSION['username']]; ?>
        </h1>
        <h1>Prestiti</h1>
        <p>Prestiti in corso ed effettuati</p>
        <?php $table = $_SESSION['formattedTable']; ?>
        <table>
        <?php for($i = 0; $i < count($table); $i++): ?>
            <tr>
                <?php foreach ($table[$i] as $part): ?>
                    <?php if($i == 0): ?>
                        <th>
                    <?php else: ?>
                        <td>
                    <?php endif; ?>
                    <?php echo $part ?>
                    <?php if($i == 0): ?>
                        </th>
                    <?php else: ?>
                        </td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        <?php endfor; ?>
        </table>
        <br>
    </div>
</div>
</body>