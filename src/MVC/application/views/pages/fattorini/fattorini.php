<div class="container padding-footer text-center">
    <h1>FATTORINI</h1>
    <br>
    <div class="row col-md-12 table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Consegne effettuate oggi</th>
                <th scope="col">Stato</th>
            </tr>
            </thead>
            <tbody>
                <?php if(isset($_SESSION['fattorini']) && count($_SESSION['fattorini']) > 0): ?>
                    <?php foreach ($_SESSION['fattorini'] as $fattorino): ?>
                        <?php echo "<tr><td>" . $fattorino['username'] . "</td><td style='text-danger'>DA FARE</td><td>"; ?>
                        <?php if($fattorino['inServizio'] == 1){echo "<span class=\"badge badge-danger\">In Servizio</span>";}else{echo "<span class=\"badge badge-success\">Libero</span>";} ?>
                        <?php echo "</td></tr>"; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo "<tr><td colspan='3'>Nessun fattorino trovato.</td></tr>"; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

