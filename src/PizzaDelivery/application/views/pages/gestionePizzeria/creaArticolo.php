<?php if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0): ?>
    <div class="col-md-12 container text-center padding-footer">
        <h1>Aggiungi Articolo</h1>
        <br>
        <form action="<?php echo URL . "gestionePizzeria/createArticolo" ?>" method="post">
            <div class="table-responsive col-md-6 mx-auto">
                <table class="table table-striped">
                    <tbody>
                        <tr class="text-inline">
                            <td scope="col">Nome<span class="text-danger"> *</span></td>
                            <td><input type="text" class="form-control" name="nomeNA" required></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Descrizione<span class="text-danger"> *</span></td>
                            <td><input type="text" class="form-control" name="descrizioneNA" required></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Prezzo<span class="text-danger"> *</span></td>
                            <td><input type="number" class="form-control" name="prezzoNA" step=".01" min="0" required></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Nome immagine</td>
                            <td><input type="text" class="form-control" name="nomeImmaginaNA" placeholder="ES: immagine.png"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <a href="<?php echo URL . "gestionePizzeria/home";?>" class="btn btn-danger btn-lg">Esci</a>
            <button type="submit" class="btn btn-primary btn-lg" id="aggiungi">Aggiungi</button>
        </form>
    </div>

    <script src="<?php echo URL; ?>application/scripts/controllaInserimentoArticolo.js"></script>
<?php else: ?>
    <?php echo "<h3 class='text-center align-middle centerVerticallyDiv'><span class='text-danger'>ERRORE</span>: Permessi insufficienti.</h3>"; ?>
<?php endif; ?>

