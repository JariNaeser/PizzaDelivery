<!-- TO FIX:

 - remove space on the right of eleziona prodotti
 - fix initial forms and maybe add google maps map

 -->

<form class="container col-md-12" style="padding-bottom: 70px; margin: 1em">
    <h1 class="text-center">ORDINA</h1>
    <h4>Informazioni personali</h4>
    <div class="row">
        <div class="form-row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Nome" name="nome" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Cognome" name="cognome" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Paese" name="paese" required>
            </div>
        </div>
        <div class="form-row">
            <div class="col-5">
                <input type="text" class="form-control" placeholder="Via" name="via" required>
            </div>
            <div class="col">
                <input type="number" class="form-control" placeholder="Nr." name="numero" required>
            </div>
            <div class="col-5">
                <input type="number" class="form-control" placeholder="Nr. Telefono" name="numeroTelefono" required>
            </div>
        </div>
    </div>
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
                            "<a href='" . URL . "home/addToCart/" . $articolo . "'><i class='fas fa-shopping-cart'></i></a></td>"?>
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
                <th scope="col">Quantità</th>
                <th scope="col">Prezzo</th>
                <th scope="col">Prezzo Totale</th>
            </tr>
            </thead>
            <tbody>

            <?php $cart = $_SESSION['cart']; ?>
            <?php var_dump($cart); ?>

            <!--
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            -->
            </tbody>
        </table>
    </div>
    <div class="col-md-12 text-center">
        <a href="" class="btn btn-danger btn-lg">Ordina</a>
    </div>
</form>
