<?php if(isset($_SESSION['articoloToModify']) && count($_SESSION['articoloToModify']) > 0): ?>
    <?php $articoloToModify = $_SESSION['articoloToModify'][0]; ?>
    <div class="col-md-12 container text-center padding-footer">
        <h1>Articolo "<?php echo $articoloToModify['nome']; ?>"</h1>
        <br>
        <form action="<?php echo URL . "gestionePizzeria/modifyArticoloContent"?>" method="post">
            <div class="table-responsive col-md-6 mx-auto">
                <table class="table table-striped">
                    <tbody>
                    <tr class="text-inline">
                        <td scope="col">Nome<span class="text-danger"> *</span></td>
                        <td><input type="text" class="form-control" name="nomeMA" required value="<?php echo $articoloToModify['nome']; ?>"></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">Descrizione<span class="text-danger"> *</span></td>
                        <td><input type="text" class="form-control" name="descrizioneMA" required value="<?php echo $articoloToModify['descrizione']; ?>"></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">Prezzo<span class="text-danger"> *</span></td>
                        <td><input type="number" class="form-control" name="prezzoMA" required value="<?php echo $articoloToModify['prezzo']; ?>"></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">Path immagine</td>
                        <td><input type="text" class="form-control" name="pathImmaginaMA" value="<?php echo $articoloToModify['urlFoto']; ?>"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <a href="<?php echo URL . "gestionePizzeria/home";?>" class="btn btn-danger btn-lg">Esci</a>
            <a href="<?php echo URL . "gestionePizzeria/eliminaArticolo/" . $articoloToModify['id'];?>" class="btn btn-warning btn-lg">Elimina</a>
            <button type="submit" class="btn btn-primary btn-lg">Aggiorna</button>
        </form>
    </div>
<?php else: ?>
    <div class="col-md-12 container text-center">
        <h1 class='text-danger text-center'>ERRORE: Nessun articolo trovato.</h1>
        <a href="<?php echo URL?>home/index" class="btn btn-danger btn-lg">Torna alla home</a>
    </div>
<?php endif; ?>


