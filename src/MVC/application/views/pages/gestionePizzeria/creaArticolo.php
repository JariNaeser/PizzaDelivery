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
                        <td><input type="number" class="form-control" name="prezzoNA" required></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">Nome immagine</td>
                        <td><input type="text" class="form-control" name="nomeImmaginaNA" placeholder="ES: immagine.png"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a href="<?php echo URL . "gestionePizzeria/home";?>" class="btn btn-danger btn-lg">Esci</a>
        <button type="submit" class="btn btn-success btn-lg">Aggiungi</button>
    </form>
</div>


