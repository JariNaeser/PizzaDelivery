<?php if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0): ?>
    <div class="container padding-footer">
        <h1 class="text-center">GESTIONE</h1>
        <br>
        <h3>Gestisci Utenti</h3>
        <hr>
        <div class="text-center">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <input type="text" class="form-control col-md-12" placeholder="Cerca Utente" id="cercaUtente">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="<?php echo URL?>gestionePizzeria/creaUtente" class="btn btn-danger btn-md col-sm-12">
                                    <i class="fas fa-plus"></i> Crea Utente
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Tipologia</th>
                        <th scope="col">Abilitato</th>
                        <th scope="col">Modifica</th>
                    </tr>
                    </thead>
                    <tbody id="utentiTable">
                        <?php if(isset($_SESSION['utenti']) && count($_SESSION['utenti']) > 0): ?>
                            <?php $utenti = $_SESSION['utenti']; ?>
                            <?php foreach ($utenti as $utente): ?>
                                <tr>
                                    <td><?php if($utente['utenteAbilitato'] == 1){echo $utente['username'];}else{echo "<strike class='text-danger'> <span class='text-dark'>" . $utente['username'] . "</span></strike>";}?></td>
                                    <td><?php echo $utente['tipoUtente'];?></td>
                                    <td><?php if($utente['utenteAbilitato'] == 1){echo "<i class=\"fas fa-check\"></i>";}else{echo "<i class=\"fas fa-times\"></i>";}?></td>
                                    <td>
                                        <a href='<?php echo URL . "gestionePizzeria/modifyUser/" . $utente['username']; ?>' class='text-dark'>
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php echo "<tr><td colspan='4'>Nessun utente trovato nel DB.</td>"; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <h3>Gestisci Articoli</h3>
        <hr>
        <div class="text-center">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <input type="text" class="form-control col-md-12" placeholder="Cerca Articolo" id="cercaArticolo"><br>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="<?php echo URL?>gestionePizzeria/creaArticolo" class="btn btn-danger btn-md col-sm-12">
                                    <i class="fas fa-plus"></i> Aggiungi Articolo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Immagine</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Prezzo</th>
                        <th scope="col">Abilitato</th>
                        <th scope="col">Modifica</th>
                    </tr>
                    </thead>
                    <tbody id="articoliTable">
                    <?php if(isset($_SESSION['prodotti']) && count($_SESSION['prodotti']) > 0): ?>
                        <?php $prodotti = $_SESSION['prodotti']; ?>
                        <?php foreach ($prodotti as $prodotto): ?>
                            <tr>
                                <td><img style='height: 50px; width: 50px;' src='<?php echo URL . $prodotto['urlFoto']; ?>'></td>
                                <td><?php if($prodotto['articoloAttivo'] == 1){echo $prodotto['nome'];}else{echo "<strike class='text-danger'> <span class='text-dark'>" . $prodotto['nome'] . "</span></strike>";}?></td>
                                <td><?php echo $prodotto['prezzo'];?></td>
                                <td><?php if($prodotto['articoloAttivo'] == 1){echo "<i class=\"fas fa-check\"></i>";}else{echo "<i class=\"fas fa-times\"></i>";}?></td>
                                <td>
                                    <a href='<?php echo URL . "gestionePizzeria/modifyArticolo/" . $prodotto['id']; ?>' class='text-dark'>
                                        <i class="fas fa-user-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php echo "<tr><td colspan='5'>Nessun prodotto trovato nel DB.</td>"; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>

        //Script che si occupa della ricerca nelle due tabelle.
        //Idea presa da https://www.w3schools.com/bootstrap4/bootstrap_filters.asp

        $(document).ready(function(){
            //Tabella Utente
            $("#cercaUtente").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#utentiTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            //Tabella Articolo
            $("#cercaArticolo").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#articoliTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
<?php else: ?>
    <?php echo "<h3 class='text-center align-middle centerVerticallyDiv'><span class='text-danger'>ERRORE</span>: Permessi insufficienti.</h3>"; ?>
<?php endif; ?>

