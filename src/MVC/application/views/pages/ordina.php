<div class="container" style="padding-bottom: 70px">
    <div class="col-md-12">
        <h1>ORDINA</h1>
        <div class="row">
            <div class="col-md-4 align-self-start">
                <input type="text" placeholder="Nome" name="nome" required>
                <input type="text" placeholder="Cognome" name="cognome" required>
                <input type="number" placeholder="Numero Telefono" name="numeroTelefono" required>
            </div>
            <div class="col-md-8 bg-secondary">
                <!-- Google maps map selector -->
                <input type="text" placeholder="Via" name="via" required>
                <input type="number" placeholder="Nr" name="numero" required>
            </div>
        </div>
        <div class="row">
            <h3 style="margin-top: 1em">Seleziona Prodotti</h3>
            <div class="row table-responsive">
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
</div>