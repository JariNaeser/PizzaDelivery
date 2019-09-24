<div class="container col-md-12" style="padding-bottom: 70px">

        <h1>ORDINA</h1>
        <div class="row">
            <form class="col-md-12">
                <div class="form-row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Nome" name="nome" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Cognome" name="cognome" required>
                    </div>
                    <div class="col-6">
                        <input type="number" class="form-control" placeholder="Numero Telefono" name="numeroTelefono" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <input type="text" class="form-control" placeholder="Via" name="via" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Nr." name="numero" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Paese" name="paese" required>
                    </div>
                </div>
            </form>
        </div>
        <div class="row col-md-12">
            <h3 style="margin-top: 1em">Seleziona Prodotti</h3>
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
                    <?php $varMemorizzaCount = 0; ?>

                    <?php foreach ($articoli as $articolo): ?>
                        <?php echo "<tr>" ?>

                        <?php echo "<td><img style='height: 50px; width: 50px;' src='"
                            . URL . $articolo['urlFoto'] . "'><td>" . $articolo['nome']
                            . "<td>" . $articolo['descrizione'] . "<td>"
                            . $articolo['prezzo'] . "</td><td>" .
                            "<i class=\"fas fa-plus\"></i> " .
                            "<i class=\"fas fa-minus\"></i> " .
                            $varMemorizzaCount . "</td>"?>

                        <?php echo "</tr>" ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <ul class="list-group text-center">
                <li class="list-group-item">Cras justo odio</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Morbi leo risus</li>
                <li class="list-group-item">Porta ac consectetur ac</li>
                <li class="list-group-item">Vestibulum at eros</li>
            </ul>
        </div>

</div>