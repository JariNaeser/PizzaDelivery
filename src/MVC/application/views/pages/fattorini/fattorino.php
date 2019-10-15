<div class="container padding-footer text-center">
    <?php if(isset($_SESSION['fattorino']) && count($_SESSION['fattorino']) > 0 && isset($_SESSION['userFattorino']) && count($_SESSION['userFattorino']) > 0): ?>
        <?php $fattorino = $_SESSION['fattorino'][0]; ?>
        <?php $userFattorino = $_SESSION['userFattorino'][0]; ?>
        <h1>FATTORINO "<?php echo $fattorino['username']; ?>"</h1>
        <br>
        <br>
        <div class="row">
            <table class="table table-borderless col-md-6 text-left">
                <tbody>
                <tr>
                    <td><b>Nome</b>: <?php echo $userFattorino['nome']; ?></td>
                </tr>
                <tr>
                    <td><b>Cognome</b>: <?php echo $userFattorino['cognome']; ?></td>
                </tr>
                <tr>
                    <td><b>E-mail</b>: <?php echo $userFattorino['email']; ?></td>
                </tr>
                <tr>
                    <td><b>Via:</b> <?php echo $userFattorino['via']; ?></td>
                </tr>
                <tr>
                    <td><b>Stato:</b> <?php if($fattorino['inServizio'] == 1){echo "<span class=\"badge badge-danger\">In Servizio</span>";}else{echo "<span class=\"badge badge-success\">Libero</span>";} ?></td>
                </tr>
                </tbody>
            </table>
            <div class="col-md-6 bg-dark">
                <p class="text-white">Google maps</p>
            </div>
        </div>
        <br>
        <br>
        <h3 class="text-left">Consegne effettuate <span style="color: gray;">[<?php echo date("d.m.Y"); ?>]</span></h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ID Consegna</th>
                    <th scope="col">Orario</th>
                    <th scope="col">Via</th>
                    <th scope="col">Incasso</th>
                </tr>
                </thead>
                <tbody>
                    <?php if(isset($_SESSION['consegneFattorino']) && count($_SESSION['consegneFattorino']) > 0):?>
                        <?php foreach ($_SESSION['consegneFattorino'] as $consegna): ?>
                            <?php echo "<tr><td>" . $consegna['id'] . "</td><td>" . $consegna['data'] . "</td><td>" . $consegna['via'] . "</td><td>" . $consegna['costoTotale'] . "</td></tr>"; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php echo "<tr><td colspan='4'>Nessuna consegna trovata.</td>"; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="<?php echo URL?>ordinazioni/home" class="btn btn-danger btn-lg">Torna agli ordini</a>
        </div>
    <?php else: ?>
        <div class="centerVerticallyDiv">
            <h1 class="text-danger">ERRORE: Il fattorino non è stato trovato.</h1>
            <br>
            <a href="<?php echo URL?>fattorini/home" class="btn btn-danger btn-lg">Torna ai fattorini</a>
        </div>
    <?php endif; ?>
</div>