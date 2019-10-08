<?php if(isset($_SESSION['userToModify']) && count($_SESSION['userToModify']) > 0): ?>
    <?php $userToModify = $_SESSION['userToModify'][0]; ?>
    <div class="col-md-12 container text-center padding-footer">
        <h1>Utente <?php echo $userToModify['username']; ?></h1>
        <br>
        <form>
            <div class="table-responsive col-md-6 mx-auto">
                <table class="table table-striped">
                    <tbody>
                        <tr class="text-inline">
                            <td scope="col">Username</td>
                            <td><input type="text" class="form-control" value="<?php echo $userToModify['username']; ?>"></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Nome</td>
                            <td><input type="text" class="form-control" value="<?php echo $userToModify['nome']; ?>"></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Cognome</td>
                            <td><input type="text" class="form-control" value="<?php echo $userToModify['cognome']; ?>"></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Via</td>
                            <td><input type="text" class="form-control" value="<?php echo $userToModify['via']; ?>"></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">CAP</td>
                            <td><input type="number" class="form-control" value="<?php echo $userToModify['cap']; ?>"></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Paeser</td>
                            <td><input type="text" class="form-control" value="<?php echo $userToModify['paese']; ?>"></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">E-Mail</td>
                            <td><input type="email" class="form-control" value="<?php echo $userToModify['email']; ?>"></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Password</td>
                            <td><button class="btn btn-primary btn-sm">Modifica Password</button></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Tipologia</td>
                            <td><input type="text" class="form-control" value="<?php echo $userToModify['tipoUtente']; ?>"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-danger btn-lg">Aggiorna</button>
            <a href="<?php echo URL . "home/gestionePizzeria";?>" class="btn btn-danger btn-lg">Esci</a>
        </form>


    </div>
<?php else: ?>
    <div class="col-md-12 container text-center">
        <h1 class='text-danger text-center'>ERRORE: Nessun utente trovato.</h1>
        <a href="<?php echo URL?>home/index" class="btn btn-danger btn-lg">Torna alla home</a>
    </div>
<?php endif; ?>


