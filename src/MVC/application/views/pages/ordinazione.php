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
    <h1 class="text-danger">Fix table, show all elements</h1>
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
            <?php for($i = 0; $i < count($ordine[1]); $i++): ?>
                <?php echo "<tr><td>" . $ordine[$i][0]['quantita'] . "x " . $articoli[$ordine[$i][0]['articolo']]['nome'] . "</td><td>" . $articoli[$ordine[$i][0]['articolo']]['prezzo'] . ".-</td><td>" . $ordine[$i][0]['quantita']*$articoli[$ordine[$i][0]['articolo']]['prezzo'] . "</td></tr>"?>
            <?php endfor; ?>
        <?php else: ?>
            <?php echo "<tr><td colspan='3'>Nessuna elemento trovato.</td></tr>"?>
        <?php endif; ?>
        </tbody>
    </table>
    </div>

    <?php echo count($ordine); ?>
    <pre><?php print_r($ordine); ?></pre>
    <pre><?php print_r($articoli); ?></pre>

    <div class="text-center">
        <a href="<?php echo URL?>home/ordinazioni" class="btn btn-danger btn-lg">Torna agli ordini</a>
    </div>
</div>