<?php if(isset($_SESSION['articoloToModify']) && count($_SESSION['articoloToModify']) > 0): ?>
    <?php $articoloToModify = $_SESSION['articoloToModify'][0]; ?>
    <div class="col-md-12 container text-center padding-footer">
        <h1>Articolo <?php echo $articoloToModify['nome']; ?></h1>
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
                        <td><input type="number" class="form-control" name="prezzoMA" min="0" step=".01" required value="<?php echo $articoloToModify['prezzo']; ?>"></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">Path immagine</td>
                        <td><input type="text" class="form-control" name="pathImmaginaMA" value="<?php echo $articoloToModify['urlFoto']; ?>"></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">Stato</td>
                        <td>
                            <?php if($articoloToModify['articoloAttivo'] == 1): ?>
                                <a href="<?php echo URL . "gestionePizzeria/disabilitaArticolo/" . $articoloToModify['id'];?>" class="btn btn-secondary btn-md">Disabilita</a>
                            <?php else: ?>
                                <a href="<?php echo URL . "gestionePizzeria/abilitaArticolo/" . $articoloToModify['id'];?>" class="btn btn-secondary btn-md">Abilita</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <a href="<?php echo URL . "gestionePizzeria/home";?>" class="btn btn-danger btn-lg">Esci</a>
            <a class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modaleElimina">Elimina</a>
            <button type="submit" class="btn btn-primary btn-lg" id="aggiornaArticolo">Aggiorna</button>
        </form>

        <!-- Modal -->
        <div class="modal fade" id="modaleElimina" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="exampleModalLabel">ATTENZIONE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Sei sicuro di voler eliminare il prodotto <?php echo $articoloToModify['nome']; ?> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                        <a href="<?php echo URL . "gestionePizzeria/eliminaArticolo/" . $articoloToModify['id']; ?>" class="btn btn-warning btn-md">Conferma</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php else: ?>
    <div class="col-md-12 container text-center">
        <h1 class='text-danger text-center'>ERRORE: Nessun articolo trovato.</h1>
        <a href="<?php echo URL?>home/index" class="btn btn-danger btn-lg">Torna alla home</a>
    </div>
<?php endif; ?>

<script src="<?php echo URL; ?>application/scripts/controllaModificaArticolo.js"></script>


