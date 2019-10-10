<?php if(isset($_SESSION['userToModify']) && count($_SESSION['userToModify']) > 0): ?>
    <?php $userToModify = $_SESSION['userToModify'][0]; ?>
    <div class="col-md-12 container text-center padding-footer">
        <h1>Utente <?php echo $userToModify['username']; ?></h1>
        <br>
        <form action="<?php echo URL . "gestionePizzeria/modifyUserContent"?>" method="post">
            <div class="table-responsive col-md-6 mx-auto">
                <table class="table table-striped">
                    <tbody>
                        <tr class="text-inline">
                            <td scope="col">Nome</td>
                            <td><input type="text" class="form-control" value="<?php echo $userToModify['nome']; ?>" name="nomeMU" required></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Cognome</td>
                            <td><input type="text" class="form-control" value="<?php echo $userToModify['cognome']; ?>" name="cognomeMU" required></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Via</td>
                            <td><input type="text" class="form-control" value="<?php echo $userToModify['via']; ?>" name="viaMU" required></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">CAP</td>
                            <td><input type="number" class="form-control" value="<?php echo $userToModify['cap']; ?>" name="capMU" required></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Paese</td>
                            <td><input type="text" class="form-control" value="<?php echo $userToModify['paese']; ?>" name="paeseMU" required></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">E-Mail</td>
                            <td><input type="email" class="form-control" value="<?php echo $userToModify['email']; ?>" name="emailMU" required></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Password</td>
                            <td><input type="password" class="form-control" placeholder="Password non mostrata." name="passwordMU"></td>
                        </tr>
                        <tr class="text-inline">
                            <td scope="col">Tipologia</td>
                            <td>
                                <select class="form-control" name="tipologiaMU" required>
                                    <?php if(isset($_SESSION['userTypes'])): ?>
                                        <?php foreach($_SESSION['userTypes'] as $type): ?>
                                            <?php if(strcmp($type['nome'], $userToModify['tipoUtente']) == 0): ?>
                                                <?php echo "<option selected='selected'>" . $type['nome'] . "</option>"; ?>
                                            <?php else: ?>
                                                <?php echo "<option>" . $type['nome'] . "</option>"; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <?php echo "<option>Nessun elemento trovato</option>"; ?>
                                    <?php endif; ?>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <a href="<?php echo URL . "gestionePizzeria/eliminaUtente/" . $userToModify['username'];?>" class="btn btn-danger btn-lg">Elimina</a>
            <button type="submit" class="btn btn-primary btn-lg">Aggiorna</button>
            <a href="<?php echo URL . "gestionePizzeria/home";?>" class="btn btn-danger btn-lg">Esci</a>
        </form>


    </div>
<?php else: ?>
    <div class="col-md-12 container text-center">
        <h1 class='text-danger text-center'>ERRORE: Nessun utente trovato.</h1>
        <a href="<?php echo URL?>home/index" class="btn btn-danger btn-lg">Torna alla home</a>
    </div>
<?php endif; ?>


