<div class="container">
    <h1 class="text-center">GESTIONE</h1>
    <br>
    <h3>Gestisci Utenti</h3>
    <hr>
    <form class="text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <input type="email" class="form-control col-md-8" placeholder="Cerca Utente">
                        <button class="btn btn-danger col-sm-3"><i class="fas fa-search"></i> Cerca</button>
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
</div>


