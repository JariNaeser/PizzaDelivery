<div class="container text-center">
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

            <?php else: ?>
                <?php echo "<tr><td colspan='4'>Nessuna ordinazione trovata.</td></tr>"?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>