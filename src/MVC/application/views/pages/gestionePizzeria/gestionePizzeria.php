<div class="container padding-footer">
    <h1 class="text-center">GESTIONE</h1>
    <br>
    <h3>Gestisci Utenti</h3>
    <hr>
    <form class="text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <input type="text" class="form-control col-md-8" placeholder="Cerca Utente">
                        <button class="btn btn-danger col-sm-3" type="submit"><i class="fas fa-search"></i> Cerca</button>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="<?php echo URL?>gestionePizzeria/creaUtente" class="btn btn-danger btn-md col-sm-12"><i class="fas fa-plus"></i> Crea Utente</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Tipologia</th>
                <th scope="col">Modifica</th>
            </tr>
            </thead>
            <tbody>
                <?php if(isset($_SESSION['utenti']) && count($_SESSION['utenti']) > 0): ?>
                    <?php $utenti = $_SESSION['utenti']; ?>
                    <?php foreach ($utenti as $utente): ?>
                        <?php echo "<tr><td>" . $utente['username'] . "</td><td>" . $utente['tipoUtente'] . "</td><td><a href='" . URL . "gestionePizzeria/modifyUser/" . $utente['username'] . "' class='text-dark'><i class=\"fas fa-user-edit\"></i></a></td></tr>" ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo "<tr><td colspan='3'>Nessun utente trovato nel DB.</td>"; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </form>
    <br>
    <h3>Gestisci Articoli</h3>
    <hr>
    <form class="text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <input type="text" class="form-control col-md-8" placeholder="Cerca Articolo">
                        <button class="btn btn-danger col-sm-3" type="submit"><i class="fas fa-search"></i> Cerca</button>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="<?php echo URL?>gestionePizzeria/creaArticolo" class="btn btn-danger btn-md col-sm-12"><i class="fas fa-plus"></i> Aggiungi Articolo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Immagine</th>
                <th scope="col">Nome</th>
                <th scope="col">Prezzo</th>
                <th scope="col">Modifica</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($_SESSION['prodotti']) && count($_SESSION['prodotti']) > 0): ?>
                <?php $prodotti = $_SESSION['prodotti']; ?>
                <?php foreach ($prodotti as $prodotto): ?>
                    <?php echo "<tr><td><img style='height: 50px; width: 50px;' src='" . URL . $prodotto['urlFoto']
                        . "'></td><td>" . $prodotto['nome'] . "</td><td>" . $prodotto['prezzo'] . "</td><td><a href='" . URL . "gestionePizzeria/modifyArticolo/" . $prodotto['id'] . "' class='text-dark'><i class=\"fas fa-user-edit\"></i></a></td></tr>" ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php echo "<tr><td colspan='4'>Nessun prodotto trovato nel DB.</td>"; ?>
            <?php endif; ?>
            </tbody>
        </table>

    </form>
</div>


