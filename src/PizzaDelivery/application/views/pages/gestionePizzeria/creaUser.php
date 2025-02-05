<?php if(isset($_SESSION['user']) && strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0): ?>
    <div class="col-md-12 container text-center padding-footer">
        <h1>Crea Utente</h1>
        <br>
        <form action="<?php echo URL . "gestionePizzeria/createUser" ?>" method="post">
            <div class="table-responsive col-md-6 mx-auto">
                <table class="table table-striped">
                    <tbody>
                    <tr class="text-inline">
                        <td scope="col">Nome<span class="text-danger"> *</span></td>
                        <td><input type="text" class="form-control" name="nomeNU" required></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">Cognome<span class="text-danger"> *</span></td>
                        <td><input type="text" class="form-control" name="cognomeNU" required></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">Via<span class="text-danger"> *</span></td>
                        <td><input type="text" class="form-control" name="viaNU" required></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">CAP<span class="text-danger"> *</span></td>
                        <td><input type="number" class="form-control" name="capNU" required></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">Paese<span class="text-danger"> *</span></td>
                        <td><input type="text" class="form-control" name="paeseNU" required></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">E-Mail<span class="text-danger"> *</span></td>
                        <td><input type="email" class="form-control" name="emailNU" required></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">Password<span class="text-danger"> *</span></td>
                        <td><input type="password" class="form-control" name="passwordNU" required></td>
                    </tr>
                    <tr class="text-inline">
                        <td scope="col">Tipologia<span class="text-danger"> *</span></td>
                        <td>
                            <select class="form-control" name="tipologiaNU" required>
                                <?php if(isset($_SESSION['userTypes'])): ?>
                                    <?php foreach($_SESSION['userTypes'] as $type): ?>
                                        <?php echo "<option>" . $type['nome'] . "</option>"; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <a href="<?php echo URL . "gestionePizzeria/home";?>" class="btn btn-danger btn-lg">Esci</a>
            <button type="submit" class="btn btn-primary btn-lg" id="crea">Crea</button>
        </form>
    </div>
    <script src="<?php echo URL; ?>application/scripts/controllaInserimentoUtente.js"></script>
<?php else: ?>
    <?php echo "<h3 class='text-center align-middle centerVerticallyDiv'><span class='text-danger'>ERRORE</span>: Permessi insufficienti.</h3>"; ?>
<?php endif; ?>
