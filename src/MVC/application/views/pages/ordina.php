<!-- TO FIX:

 - remove space on the right of eleziona prodotti

 -->

<form class="container col-md-12" style="padding-bottom: 70px; margin: 1em">
    <h1 class="text-center">ORDINA</h1>
    <div class="row col-md-12">
        <h4 style="margin-top: 1em">Seleziona Prodotti</h4>
        <div class="row table-responsive col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Immagine</th>
                    <th scope="col">Articolo</th>
                    <th scope="col">Descrizione</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Aggiungi</th>
                </tr>
                </thead>
                <tbody>
                <?php $articoli = $_SESSION['articoli']; ?>
                <?php if(count($articoli) != 0): ?>
                    <?php foreach ($articoli as $articolo): ?>
                        <?php $nome = $articolo['nome'] ?>
                        <?php echo "<tr>" ?>

                        <?php echo "<td><img style='height: 50px; width: 50px;' src='"
                            . URL . $articolo['urlFoto'] . "'><td>" . $articolo['nome']
                            . "<td>" . $articolo['descrizione'] . "<td>"
                            . $articolo['prezzo'] . "</td><td>" .
                            "<a href='" . URL . "home/addToCart/" . $articolo['id'] . "'><i class='fas fa-shopping-cart' alt='X'></i></a></td>"?>
                        <?php echo "</tr>" ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo "<tr><td colspan='5' class='text-center'>Nessun prodotto disponibile.</td></tr>" ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <h4>Prodotti selezionati</h4>
    <div class="row col-md-12 table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Immagine</th>
                <th scope="col">Articolo</th>
                <th scope="col">Prezzo</th>
            </tr>
            </thead>
            <tbody>
            <?php $cart = $_SESSION['cart']; ?>
            <?php if(count($cart) == 0): ?>
                <?php echo "<tr><td colspan='5' class='text-center'>Nessun elemento selezionato.</td></tr>"; ?>
            <?php else: ?>
                <?php if(count($cart) > 0): ?>
                    <?php foreach ($cart as $element): ?>
                        <?php echo "<tr><td><img style='height: 50px; width: 50px;' src='" . URL . $element['urlFoto']
                            . "'></td><td>" . $element['nome'] . "</td><td>"
                            . $element['prezzo'] . "</td></tr>"; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>
            </tbody>
            <h1 class="text-danger">Mettere a posto parte php di questa classe</h1>
        </table>
    </div>
    <div class="col-md-12 text-center">
        <a href='<?php echo URL . "home/confermaordine"; ?>' class="btn btn-danger btn-lg">Prosegui all'ordinazione</a>
    </div>
</form>
