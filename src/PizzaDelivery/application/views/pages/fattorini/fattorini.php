<?php if(isset($_SESSION['user']) && (strcmp($_SESSION['user'][0]['tipoUtente'], 'amministratore') == 0 || strcmp($_SESSION['user'][0]['tipoUtente'], 'impiegato vendita') == 0 || strcmp($_SESSION['user'][0]['tipoUtente'], 'fattorino') == 0)): ?>
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
                        <tr class='clickable-row' data-href='<?php echo URL . "fattorini/fattorino/" . $fattorino['username']; ?>'>
                            <td class="align-middle"><?php echo $fattorino['username']; ?></td>
                            <td class="align-middle"><?php echo $fattorino['consegneOggi']; ?></td>
                            <td class="align-middle"><?php
                                if($fattorino['inServizio'] == 1){
                                    echo "<span class=\"badge badge-danger\">In Servizio</span>";
                                }else{
                                    echo "<span class=\"badge badge-success\">Libero</span>";
                                } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo "<tr><td colspan='3'>Nessun fattorino trovato.</td></tr>"; ?>
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

<?php else: ?>
    <?php echo "<h3 class='text-center align-middle centerVerticallyDiv'><span class='text-danger'>ERRORE</span>: Permessi insufficienti.</h3>"; ?>
<?php endif; ?>