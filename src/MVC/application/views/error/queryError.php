<div class="container text-center centerVerticallyDiv" style="padding: 1em">
    <h1 class="text-danger">ERRORE</h1>
    <h3>C'è stato un problema nell'esecuzione di una query.</h3>
    <br>
    <p><?php if(isset($_SESSION['queryError'])){echo "<h3>Error:</h3>" . $_SESSION['queryError'];} ?></p>
    <a href="<?php echo URL?>home/index" class="btn btn-danger btn-lg">Torna alla home</a>
</div>