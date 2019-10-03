<div class="container padding-footer text-center">
    <h1>ORDINAZIONI</h1>
    <div class="row col-md-12 table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Immagine</th>
                <th scope="col">Articolo</th>
                <th scope="col">Descrizione</th>
                <th scope="col">Quantità</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($_SESSION['ordinazioni']) && count($_SESSION['ordinazioni']) > 0): ?>
                <?php $ordini = $_SESSION['ordinazioni']; ?>
                <?php foreach ($ordini as $ordine): ?>
                    <?php echo "<tr class='clickable-row' data-href='" . URL . "home/ordinazione/" . $ordine[0]['id'] . "'><td>" . $ordine[0]['id'] . "</td><td>" . $ordine[0]['nomeCliente'] . " " . $ordine[0]['cognomeCliente'] . "</td><td>" . $ordine[0]['via'] . "</td><td>" . $ordine[1]['quantita'] . "</td></tr>" ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php echo "<tr><td colspan='4'>Nessuna ordinazione trovata.</td></tr>"?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
    </script>
</div>