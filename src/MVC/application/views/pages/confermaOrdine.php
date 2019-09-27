<script>const prezzoFinale = new Array(<?php echo count($_SESSION['cart']); ?>);</script>
<div class="col-md-12" style="padding-bottom: 70px; margin: 1em">
    <h4>Informazioni personali</h4>
    <div class="row">
        <div class="form-row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Nome" name="nome" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Cognome" name="cognome" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Paese" name="paese" required>
            </div>
        </div>
        <div class="form-row">
            <div class="col-5">
                <input type="text" class="form-control" placeholder="Via" name="via" required>
            </div>
            <div class="col">
                <input type="number" class="form-control" placeholder="Nr." name="numero" required>
            </div>
            <div class="col-5">
                <input type="number" class="form-control" placeholder="Nr. Telefono" name="numeroTelefono" required>
            </div>
        </div>
    </div>
    <h1 class="text-danger">Aggiornare totale e allineare a destra.</h1>
    <h4>Prodotti selezionati</h4>
    <div class="row col-md-12 table-responsive">
        <table class="table table-striped">
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
            <?php $cart = $_SESSION['cart']; ?>
            <?php if(count($cart) == 0): ?>
                <?php echo "<tr><td colspan='5' class='text-center'>Nessun elemento selezionato.</td></tr>"; ?>
            <?php else: ?>
                <?php if(count($cart) > 0): ?>
                    <?php foreach ($cart as $element): ?>

                        <?php $select = "<select class='form-control form-control-sm' id='select" . $element[0]['id'] . "'>";
                                        for($i = 0; $i < 31; $i++){if($i == 1){$select .= "<option selected='selected'>$i</option>";}else{$select .= "<option>$i</option>";}}
                                        $select .= "</select>" ?>

                        <?php echo "<tr id='" . $element[0]['id'] . "'><td><img style='height: 50px; width: 50px;' src='" . URL . $element[0]['urlFoto']
                            . "'></td><td>" . $element[0]['nome'] . "</td><td>"
                            . $element[0]['descrizione'] . "</td><td>"
                            . $select . "</td><td>"
                            . $element[0]['prezzo'] . "</td><td id='total" . $element[0]['id'] . "'>x</td></tr>";?>

                            <script>

                                var select = $('#select<?php echo $element[0]['id']; ?>');
                                calculatePrice<?php echo $element[0]['id']; ?>();

                                function calculatePrice<?php echo $element[0]['id']; ?>(){
                                    select = $('#select<?php echo $element[0]['id']; ?>');
                                    var num = select.val();
                                    var price = <?php echo $element[0]['prezzo']; ?>;
                                    $('#total<?php echo $element[0]['id']; ?>').text(num * price);
                                    prezzoFinale[(<?php echo $element[0]['id']; ?> - 1)] = (num * price);
                                }

                                select.change(function(){
                                    calculatePrice<?php echo $element[0]['id']; ?>();
                                });

                            </script>


                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>

            <tr><td colspan="5" id="totalPrice"></td></tr>
            <script>
                var total = 0;
                for(var i = 0; i < prezzoFinale.length; i++){
                    total += prezzoFinale[i];
                }
                $('#totalPrice').text("Totale: " + total + ".-");
            </script>

            </tbody>
        </table>
    </div>
    <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-danger btn-lg">Ordina</button>
    </div>
</div>