<?php if(isset($_SESSION['articoli']) && count($_SESSION['articoli']) > 0): ?>
    <form class="container padding-footer">
        <h1 class="text-center">ORDINA</h1>
        <div class="row" style="padding: 1em">
            <h4>Seleziona Prodotti</h4>
            <div class="row table-responsive text-center">
                <table class="table table-striped">
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
                            <?php if($articolo['articoloAttivo'] == 1): ?>
                                <tr>
                                    <td><img style='height: 50px; width: 50px;' src='<?php echo URL . $articolo['urlFoto']; ?>'></td>
                                    <td><?php echo $articolo['nome']; ?></td>
                                    <td><?php echo $articolo['descrizione']; ?></td>
                                    <td><?php echo $articolo['prezzo']; ?></td>
                                    <td>
                                        <a class='text-dark' href='<?php echo URL . "ordina/addToCart/" . $articolo['id']; ?>'>
                                            <i class='fas fa-shopping-cart' alt='X'></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
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
                <?php if(isset($_SESSION['cart'])): ?>
                    <?php $cart = $_SESSION['cart']; ?>
                    <?php if(count($cart) > 0): ?>
                        <?php foreach ($cart as $element): ?>

                            <tr>
                                <td class="align-middle"><img style='height: 50px; width: 50px;' src='<?php echo URL . $element[0]['urlFoto']; ?>'></td>
                                <td class="align-middle"><?php echo $element[0]['nome']; ?></td>
                                <td class="align-middle"><?php echo $element[0]['prezzo']; ?></td>
                                <td class="align-middle">
                                    <a class='text-danger' href='<?php echo URL . "ordina/removeFromCart/" . $element[0]['id']; ?>'>
                                        <i class='fas fa-times' alt='X'></i>
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php echo "<tr><td colspan='4' class='text-center'>Nessun elemento selezionato.</td></tr>"; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo "Session cart not found."; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 text-center">
            <a href='<?php echo URL . "ordina/confermaordine"?>' class="btn btn-danger btn-lg disabled" id="buttonOrdina">Prosegui all'ordinazione</a>
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
<?php else: ?>
    <?php echo "Session articoli not found."; ?>
<?php endif; ?>
