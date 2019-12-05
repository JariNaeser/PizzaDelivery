<?php if(isset($_SESSION['consegne']) && count($_SESSION['consegne']) > 0): ?>
    <?php $consegne = $_SESSION['consegne']; ?>
    <div class="container padding-footer text-center">
        <h1>CONSEGNE</h1>
        <br>
        <div class="form-group float-center" align="center">
            <label for="exampleFormControlSelect1">Fino a</label>
            <select class="form-control col-md-3" id="selectTime">
                <!-- Fill select -->
                <?php if($consegne['dropDownValue'] == 10000){echo "<option selected='selected'>Tutte</option>";}else{echo "<option>Tutte</option>";} ?>
                <?php if($consegne['dropDownValue'] == 1){echo "<option selected='selected'>Questa settimana</option>";}else{echo "<option>Questa settimana</option>";} ?>
                <?php if($consegne['dropDownValue'] == 2){echo "<option selected='selected'>2 settimane fa</option>";}else{echo "<option>2 settimane fa</option>";} ?>
                <?php if($consegne['dropDownValue'] == 3){echo "<option selected='selected'>3 settimane fa</option>";}else{echo "<option>3 settimane fa</option>";} ?>
                <?php if($consegne['dropDownValue'] == 4){echo "<option selected='selected'>1 mese fa</option>";}else{echo "<option>1 mese fa</option>";} ?>
                <?php if($consegne['dropDownValue'] == 24){echo "<option selected='selected'>6 mesi fa</option>";}else{echo "<option>6 mesi fa</option>";} ?>
                <?php unset($consegne['dropDownValue']); ?>
            </select>
        </div>
        <div class="row col-md-12 table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID Consegna</th>
                    <th scope="col">Fattorino</th>
                    <th scope="col">Data Inserimento</th>
                    <th scope="col">Data Consegna</th>
                    <th scope="col">TipoConsegna</th>
                    <th scope="col">Modifica</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($consegne) && count($consegne) > 0): ?>
                    <?php foreach ($consegne as $consegna): ?>
                        <tr>
                            <td><?php echo $consegna['id']; ?></td>
                            <td><?php echo $consegna['fattorino']; ?></td>
                            <td><?php echo $consegna['dataInserimento']; ?></td>
                            <td><?php if(isset($consegna['dataConsegna'])){echo $consegna['dataConsegna'];}else{echo "-";} ?></td>
                            <td>
                                <?php if(strcmp($consegna['tipoConsegna'], "da effettuare") == 0){
                                            echo "<span class='badge badge-danger'>Da Effettuare</span>";
                                        }else if(strcmp($consegna['tipoConsegna'], "in corso") == 0){
                                            echo "<span class='badge badge-warning'>In Corso</span>";
                                        }else{
                                            echo "<span class='badge badge-success'>Terminata</span>";
                                        }
                                ?>
                            </td>
                            <td><?php echo "<span class='modificaStato' id='" . $consegna['id'] . "'><i class='far fa-edit'></i></span>"; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo "<tr><td colspan='6'>Nessuna consegna trovata.</td></tr>"; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <form action="<?php echo URL . 'consegne/aggiornaTipoConsegna'; ?>" method="post">
            <div class="modal fade" id="modificaStatoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modifica stato Consegna <span id="deliveryNumber"></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body table-responsive">
                            <?php if(isset($_SESSION['consegne']) && count($_SESSION['consegne']) > 0): ?>
                                <?php $fattorini = $_SESSION['consegne']; ?>
                                <table class="table">
                                    <tr>
                                        <th>Seleziona</th>
                                        <th>Stato</th>
                                    </tr>
                                    <?php if(isset($_SESSION['tipiConsegne'])){$options = $_SESSION['tipiConsegne']; } ?>
                                    <?php foreach ($options as $option): ?>
                                        <tr>
                                            <td><input type="radio" name="selezioneConsegna" value="<?php echo $option['nome']; ?>" required></td>

                                            <?php switch($option['nome']){
                                                case "terminata":
                                                    echo "<td><span class='badge badge-success'>Terminata</span></td>";
                                                    break;
                                                case "in corso":
                                                    echo "<td><span class='badge badge-warning'>In Corso</span></td>";
                                                    break;
                                                case "da effettuare":
                                                    echo "<td><span class='badge badge-danger'>Da Effettuare</span></td>";
                                                    break;
                                            }?>
                                        </tr>
                                    <?php endforeach; ?>

                                </table>
                            <?php else: ?>
                                <?php echo "<h3 class='text-danger'>ERRORE: Nessun fattorino trovato.</h3>"; ?>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Esci</button>
                            <button type="submit" class="btn btn-primary">Modifica</button>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="nrOrdine" value="" id="hidden">
        </form>
        <script>
            $(document).ready(function($) {

                var select = $('#selectTime');

                select.change(function(){
                    switch (select.val()){
                        case "Questa settimana":
                            setWeeks(1);
                            break;
                        case "2 settimane fa":
                            setWeeks(2);
                            break;
                        case "3 settimane fa":
                            setWeeks(3);
                            break;
                        case "1 mese fa":
                            setWeeks(4);
                            break;
                        case "6 mesi fa":
                            setWeeks(24);
                            break;
                        case "Tutte":
                            setWeeks(10000);
                            break;
                        default:
                            setWeeks(10000);
                            break;
                    }
                });

                $(".clickable-row").click(function() {
                    window.location = $(this).data("href");
                });
            });

            function setWeeks(weeks){
                $.ajax({
                    type: "GET",
                    url: ("<?php echo URL ?>consegne/home/" + weeks),
                    dataType: "text"
                }).done(function (response) {
                    document.open();
                    document.write(response);
                    document.close();
                });
            }

            //Modal
            $('.modificaStato').click(function(e){
                $('#modificaStatoModal').modal('show');
                $('#deliveryNumber').text(" [" + this.id + "]");
                $("#hidden").val(this.id);
            });

        </script>
    </div>
<?php else: ?>
    <?php echo "Session consegne not found."; ?>
<?php endif; ?>