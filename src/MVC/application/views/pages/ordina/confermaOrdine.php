<?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
    <script>const prezzoFinale = new Array(<?php echo count($_SESSION['cart']); ?>);</script>
    <div class="container padding-footer">
        <form action="<?php echo URL . "ordina/creaOrdine"?>" method="post" style="padding: 0px;">
            <h1 class="text-center">CONFERMA ORDINE</h1>
            <h4>Informazioni personali</h4>
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Nome" name="nome" required>
                </div>
                <div class="col inner-addon right-addon">
                    <input type="text" class="form-control" placeholder="Cognome" name="cognome" required>
                </div>
            </div>
            <br>
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Paese" name="paese" required>
                </div>
                <div class="col">
                    <input type="number" class="form-control" placeholder="Nr. Telefono" name="numeroTelefono" required>
                </div>
            </div>
            <br>
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Via" name="via" required>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" placeholder="Nr." name="numero" required>
                </div>
                <div class="col-3">
                    <input type="number" class="form-control" placeholder="Cap" name="cap" required>
                </div>
            </div>
            <br>
            <h4>Prodotti selezionati</h4>
            <div class="row col-md-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Immagine</th>
                            <th scope="col">Articolo</th>
                            <th scope="col">Descrizione</th>
                            <th scope="col">Quantità</th>
                            <th scope="col">Prezzo</th>
                            <th scope="col">Prezzo finale</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <?php $cart = $_SESSION['cart']; ?>
                        <?php if(count($cart) > 0): ?>
                            <?php foreach ($cart as $element): ?>

                                <?php $select = "<select class='form-control form-control-sm' name='select"
                                                    . $element[0]['id'] . "' id='select" . $element[0]['id'] . "'>";

                                                    for($i = 0; $i < 31; $i++){
                                                        if($i == 1){
                                                            $select .= "<option selected='selected'>$i</option>";
                                                        }else{
                                                            $select .= "<option>$i</option>";
                                                        }
                                                    }
                                                    $select .= "</select>" ?>

                                <tr id="<?php echo $element[0]['id']; ?>">
                                    <td class="align-middle"><img style='height: 50px; width: 50px;' src='<?php echo URL . $element[0]['urlFoto'];?>'></td>
                                    <td class="align-middle"><?php echo $element[0]['nome']; ?></td>
                                    <td class="align-middle"><?php echo $element[0]['descrizione']; ?></td>
                                    <td class="align-middle"><?php echo $select; ?></td>
                                    <td class="align-middle"><?php echo $element[0]['prezzo']; ?></td>
                                    <td class="align-middle" id='<?php echo "total" . $element[0]['id']; ?>'>x</td>
                                </tr>

                                <script>
                                    function countTotal() {
                                        var total = 0;
                                        for(var i = 0; i < prezzoFinale.length; i++){
                                            if(prezzoFinale[i] !== undefined){
                                                total += prezzoFinale[i];
                                            }
                                        }
                                        $('#totalPrice').text(total);
                                    }

                                    var select = $('#select<?php echo $element[0]['id']; ?>');
                                    calculatePrice<?php echo $element[0]['id']; ?>();

                                    function calculatePrice<?php echo $element[0]['id']; ?>(){
                                        select = $('#select<?php echo $element[0]['id']; ?>');
                                        var num = select.val();
                                        var price = <?php echo $element[0]['prezzo']; ?>;
                                        $('#total<?php echo $element[0]['id']; ?>').text(num * price);
                                        prezzoFinale[(<?php echo $element[0]['id']; ?> - 1)] = (num * price);
                                        countTotal();
                                    }

                                    select.change(function(){
                                        calculatePrice<?php echo $element[0]['id']; ?>();
                                    });

                                </script>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php echo "<tr><td colspan='6' class='text-center'>Nessun elemento selezionato.</td></tr>"; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <h3 class="text-danger">Costo Totale: <span id="totalPrice"></span>.-</h3>
            <script>
                countTotal();
            </script>
            <div class="col-md-12 text-center">
                <a href="<?php echo URL?>ordina/home" class="btn btn-danger btn-lg">Torna all'ordine</a>
                <button type="button" class="btn btn-danger btn-lg" id="ordina">Ordina</button>
            </div>
        </form>
    </div>
<?php else: ?>
    <?php echo "Session cart not found"; ?>
<?php endif; ?>

<script src="<?php echo URL; ?>application/scripts/confermaOrdine.js"></script>