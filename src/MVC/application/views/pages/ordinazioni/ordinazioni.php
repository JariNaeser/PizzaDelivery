<div class="container padding-footer text-center">
    <h1>ORDINAZIONI</h1>
    <div class="row col-md-12 table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Cliente</th>
                <th scope="col">Posizione</th>
                <th scope="col">Pz. Ordine</th>
                <th scope="col">Assegna Ordine</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($_SESSION['ordinazioni']) && count($_SESSION['ordinazioni']) > 0): ?>
                <?php $ordini = $_SESSION['ordinazioni']; ?>
                <?php foreach ($ordini as $ordine): ?>
                    <?php $sum = 0; ?>
                    <?php for($i = 1; $i < count($ordine); $i++): ?>
                        <?php $sum += $ordine[$i]['quantita']; ?>
                    <?php endfor; ?>
                    <tr class='clickable-row' data-href='<?php echo URL . "ordinazioni/ordinazione/" . $ordine[0]['id']; ?>'>
                        <td><?php echo $ordine[0]['id']; ?></td>
                        <td><?php echo $ordine[0]['nomeCliente'] . " " . $ordine[0]['cognomeCliente']; ?></td>
                        <td><?php echo $ordine[0]['via']; ?></td>
                        <td><?php echo $sum; ?></td>
                        <td><a href="<?php echo URL?>ordina/home" class="btn btn-warning btn-md">Assegna a fattorino</a></td>
                    </tr>
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