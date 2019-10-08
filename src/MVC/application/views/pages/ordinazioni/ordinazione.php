<div class="container padding-footer">
    <?php $ordine = $_SESSION['ordine']; ?>
    <?php $articoli = $_SESSION['articoli']; ?>
    <h1 class="text-center">ORDINAZIONE #<?php echo $ordine[0][0]['id'] ?></h1>
    <br>
    <h3>Cliente</h3>
    <div class="row">
        <table class="table table-borderless col-md-6">
            <tbody>
                <tr>
                    <td><b>Nome</b>: <?php echo $ordine[0][0]['nomeCliente']; ?></td>
                </tr>
                <tr>
                    <td><b>Cognome</b>: <?php echo $ordine[0][0]['cognomeCliente']; ?></td>
                </tr>
                <tr>
                    <td><b>Telefono</b>: <?php echo $ordine[0][0]['numeroTelefonoCliente']; ?></td>
                </tr>
                <tr>
                    <td><b>Via:</b> <?php echo $ordine[0][0]['via']; ?></td>
                </tr>
            </tbody>
        </table>
        <div class="col-md-6 bg-dark">
            <p class="text-white">Google maps</p>
        </div>
    </div>
    <br>
    <br>
    <h3>Prodotti ordinati</h3>
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Prezzo</th>
                <th scope="col">Totale</th>
            </tr>
        </thead>
        <tbody>
        <?php if(isset($_SESSION['ordine']) && count($_SESSION['ordine']) > 0): ?>
            <?php foreach ($ordine[1] as $elemento): ?>
                <?php echo "<tr><td>" . $elemento['quantita'] . "x " . $articoli[$elemento['articolo']-1]['nome'] . "</td><td>" . $articoli[$elemento['articolo']-1]['prezzo'] . ".-</td><td>" . $elemento['quantita']*$articoli[$elemento['articolo']-1]['prezzo'] . "</td></tr>"?>
            <?php endforeach; ?>
        <?php else: ?>
            <?php echo "<tr><td colspan='3'>Nessuna elemento trovato.</td></tr>"?>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
    <div class="text-center">
        <a href="<?php echo URL?>ordinazioni/ordinazioni" class="btn btn-danger btn-lg">Torna agli ordini</a>
    </div>
</div>