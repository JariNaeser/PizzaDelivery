<!-- TO FIX:

 - remove space on the right of eleziona prodotti

 -->
<form class="container" style="padding: 0px; padding: 1em; padding-bottom: 70px;">
    <h1 class="text-center">ORDINA</h1>
    <div class="row" style="padding: 1em">
        <h4>Seleziona Prodotti</h4>
        <div class="row table-responsive text-center">
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
                            "<a href='" . URL . "home/addToCart/" . $articolo['id'] . "'><i class='fas fa-shopping-cart' alt='X'>X</i></a></td>"?>
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
        <table class="table table-striped text-center">
            <thead>
            <tr>
                <th scope="col">Immagine</th>
                <th scope="col">Articolo</th>
                <th scope="col">Prezzo</th>
                <th scope="col">Rimuovi</th>
            </tr>
            </thead>
            <tbody>
            <?php $cart = $_SESSION['cart']; ?>
            <?php if(count($cart) == 0): ?>
                <?php echo "<tr><td colspan='5' class='text-center'>Nessun elemento selezionato.</td></tr>"; ?>
            <?php else: ?>
                <?php if(count($cart) > 0): ?>
                    <?php foreach ($cart as $element): ?>
                        <?php echo "<tr><td><img style='height: 50px; width: 50px;' src='" . URL . $element[0]['urlFoto']
                            . "'></td><td>" . $element[0]['nome'] . "</td><td>"
                            . $element[0]['prezzo'] . "</td><td>"
                            . "<a href='" . URL . "home/removeFromCart/" . $element[0]['id'] . "'><i class='fas fa-times' alt='X'>X</i></a></td></tr>"; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-12 text-center">
        <a href='<?php echo URL . "home/confermaordine"?>' class="btn btn-danger btn-lg disabled" id="buttonOrdina">Prosegui all'ordinazione</a>
        <script>
            var elemNum = <?php echo count($_SESSION['cart']); ?>;
            if(elemNum > 0){
                $('#buttonOrdina').removeClass('disabled');
            }else{
                $('#buttonOrdina').addClass('disabled');
            }
        </script>
    </div>
</form>
