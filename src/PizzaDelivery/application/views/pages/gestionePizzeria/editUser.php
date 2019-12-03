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
                            <input type="hidden" name="usernameMU" value="<?php echo $userToModify['username']; ?>">
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
                            <td scope="col">Stato</td>
                            <td>
                                <?php if($userToModify['utenteAbilitato'] == 1): ?>
                                    <a href="<?php echo URL . "gestionePizzeria/disabilitaUtente/" . $userToModify['username'];?>" class="btn btn-secondary btn-md">Disabilita</a>
                                <?php else: ?>
                                    <a href="<?php echo URL . "gestionePizzeria/abilitaUtente/" . $userToModify['username'];?>" class="btn btn-secondary btn-md">Abilita</a>
                                <?php endif; ?>
                            </td>
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
            <a href="<?php echo URL . "gestionePizzeria/home";?>" class="btn btn-danger btn-lg">Esci</a>
            <a class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modaleElimina">Elimina</a>
            <button type="submit" class="btn btn-primary btn-lg" id="aggiorna">Aggiorna</button>
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
                        <p>Sei sicuro di voler eliminare l'utente <?php echo $userToModify['username']; ?> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                        <a href="<?php echo URL . "gestionePizzeria/eliminaUtente/" . $userToModify['username'];?>" class="btn btn-warning btn-md">Conferma</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php else: ?>
    <div class="col-md-12 container text-center centerVerticallyDiv">
        <h1 class='text-danger text-center'>ERRORE: Nessun utente trovato.</h1>
        <a href="<?php echo URL?>home/index" class="btn btn-danger btn-lg">Torna alla home</a>
    </div>
<?php endif; ?>

<script src="<?php echo URL; ?>application/scripts/controllaModificaUtente.js"></script>