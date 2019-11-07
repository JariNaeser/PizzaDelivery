<div class="container padding-footer text-center">
    <h1>ORDINAZIONI</h1>
    <br>
    <div class="row col-md-12 table-responsive">
        <table class="table" id="myTB">
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
                    <?php if($ordine[0]['prontaPerConsegna'] == 0): ?>
                        <?php $sum = 0; ?>
                        <?php for($i = 1; $i < count($ordine); $i++): ?>
                            <?php $sum += $ordine[$i]['quantita']; ?>
                        <?php endfor; ?>
                        <tr class='clickable-row' data-href='<?php echo URL . "ordinazioni/ordinazione/" . $ordine[0]['id']; ?>'>
                            <td class="align-middle"><?php echo $ordine[0]['id']; ?></td>
                            <td class="align-middle"><?php echo $ordine[0]['nomeCliente'] . " " . $ordine[0]['cognomeCliente']; ?></td>
                            <td class="align-middle"><?php echo $ordine[0]['via']; ?></td>
                            <td class="align-middle"><?php echo $sum; ?></td>
                            <td class="align-middle"><button class="btn btn-warning btn-md assegnaAFattorino" id="<?php echo $ordine[0]['id']?>">Assegna a fattorino</button></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php echo "<tr><td colspan='5'>Nessuna ordinazione trovata.</td></tr>"?>
            <?php endif; ?>
            </tbody>
        </table>
        <!-- Modal -->
        <form action="<?php echo URL . 'ordinazioni/assegnaAFattorino'; ?>" method="post">
            <div class="modal fade" id="assegnaAFattorinoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Assegna Ordinazione<span id="orderNumber"></span> ad un Fattorino</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body table-responsive">
                            <?php if(isset($_SESSION['fattoriniOrdinatiLiberiENon']) && count($_SESSION['fattoriniOrdinatiLiberiENon']) > 0): ?>
                                <?php $fattorini = $_SESSION['fattoriniOrdinatiLiberiENon']; ?>
                                <table class="table">
                                <tr>
                                    <th>Seleziona</th>
                                    <th>Nome</th>
                                    <th>Stato</th>
                                </tr>
                                <?php foreach ($fattorini as $fattorino): ?>
                                    <tr>
                                        <td><input type="radio" name="selezioneFattorino" value="<?php echo $fattorino['username']; ?>" required></td>
                                        <td><?php echo $fattorino['username']; ?></td>
                                        <td><?php
                                            if($fattorino['inServizio'] == 1){
                                                echo "<span class=\"badge badge-danger\">In Servizio</span>";
                                            }else{
                                                echo "<span class=\"badge badge-success\">Libero</span>";
                                            } ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </table>
                            <?php else: ?>
                                <?php echo "<h3 class='text-danger'>ERRORE: Nessun fattorino trovato.</h3>"; ?>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Esci</button>
                            <button type="submit" class="btn btn-warning">Assegna</button>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="nrOrdine" value="" id="hidden">
        </form>
    </div>
    <script>

        //Workaround per controllare se la tabella è vuota anche se le sessioni contengono qualcosa.
        var rowNum = $('#myTB tr').length;

        //Prima riga (titoli) inclusa.
        if(rowNum <= 1){
            $('#myTB').append("<tr><td colspan='5'>Nessuna ordinazione trovata.</td></tr>");
        }

        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });

        //Preso in parte da https://stackoverflow.com/questions/13589022/can-i-exclude-a-button-click-inside-a-tr-click-event/13589117
        $('.assegnaAFattorino').click(function(e){
            e.preventDefault();
            e.stopPropagation();
            $('#assegnaAFattorinoModal').modal('show');
            $('#orderNumber').text(" [" + this.id + "]");
            $("#hidden").val(this.id);
        });



    </script>
</div>