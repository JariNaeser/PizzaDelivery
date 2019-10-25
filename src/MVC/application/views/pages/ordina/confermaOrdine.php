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
                <script>

                    const status = [false, false, false, false, false, false, false];

                    //Si riferisce alla lunghezza massima della tabella del DB.
                    const LUNGHEZZA_MASSIMA_NOME = 50;
                    const LUNGHEZZA_MASSIMA_COGNOME = 50;
                    const LUNGHEZZA_MASSIMA_TELEFONO = 20;
                    const LUNGHEZZA_MASSIMA_VIA = 44;       //Con aggiunta di cap, 50 - 5 - 1(spazio) = 44
                    const LUNGHEZZA_MASSIMA_PAESE = 50;
                    const LUNGHEZZA_MASSIMA_CAP = 6;
                    const LUNGHEZZA_MASSIMA_NUMERO = 5;

                    function validate(string, maxLen, regex){
                        try{
                            string = string.trim();
                            if(string.length > 0 && string.length <= maxLen){
                                if(!regex.test(string)){
                                    return true;
                                }
                            }
                            return false;
                        }catch(error){
                            console.log("Error: " + error);
                            return false;
                        }
                    }

                    // nome field
                    var nameSelector = $('input[name=nome]');
                    nameSelector.blur(function(event){
                        if(validate(nameSelector.val(), LUNGHEZZA_MASSIMA_NOME, /([^A-Za-zöäüÖÄÜàèìòùÀÈÌÒÙÉé -.])/)){
                            isOk(nameSelector);
                            status[0] = true;
                        }else{
                            isNotOk(nameSelector);
                            status[0] = false;
                        }
                        checkIfOk();
                    });

                    // cognome field
                    var surnameSelector = $('input[name=cognome]');
                    surnameSelector.blur(function(event){
                        if(validate(surnameSelector.val(), LUNGHEZZA_MASSIMA_COGNOME, /([^A-Za-zöäüÖÄÜàèìòùÀÈÌÒÙÉé -.])/)){
                            isOk(surnameSelector);
                            status[1] = true;
                        }else{
                            isNotOk(surnameSelector);
                            status[1] = false;
                        }
                        checkIfOk();
                    });

                    // paese field
                    var paeseSelector = $('input[name=paese]');
                    paeseSelector.blur(function(event){
                        if(validate(paeseSelector.val(), LUNGHEZZA_MASSIMA_PAESE, /([^A-Za-zöäüÖÄÜàèìòùÀÈÌÒÙÉé -])/)){
                            isOk(paeseSelector);
                            status[2] = true;
                        }else{
                            isNotOk(paeseSelector);
                            status[2] = false;
                        }
                        checkIfOk();
                    });

                    // telefono field
                    var telefonoSelector = $('input[name=numeroTelefono]', );
                    telefonoSelector.blur(function(event){
                        if(validate(telefonoSelector.val(), LUNGHEZZA_MASSIMA_TELEFONO, /([^0-9+ ])/)){
                            isOk(telefonoSelector);
                            status[3] = true;
                        }else{
                            isNotOk(telefonoSelector);
                            status[3] = false;
                        }
                        checkIfOk();
                    });

                    // via field
                    var viaSelector = $('input[name=via]');
                    viaSelector.blur(function(event){
                        if(validate(viaSelector.val(), LUNGHEZZA_MASSIMA_VIA, /([^A-Za-zöäüÖÄÜàèìòùÀÈÌÒÙÉé -.])/)){
                            isOk(viaSelector);
                            status[4] = true;
                        }else{
                            isNotOk(viaSelector);
                            status[4] = false;
                        }
                        checkIfOk();
                    });

                    // cap field
                    var capSelector = $('input[name=cap]');
                    capSelector.blur(function(event){
                        if(validate(capSelector.val(), LUNGHEZZA_MASSIMA_CAP, /([^0-9])/)){
                            isOk(capSelector);
                            status[5] = true;
                        }else{
                            isNotOk(capSelector);
                            status[5] = false;
                        }
                        checkIfOk();
                    });

                    // numero field
                    var numeroSelector = $('input[name=numero]');
                    numeroSelector.blur(function(event){
                        if(validate(numeroSelector.val(), LUNGHEZZA_MASSIMA_NUMERO, /([^0-9A-za-z])/)){
                            isOk(numeroSelector);
                            status[6] = true;
                        }else{
                            isNotOk(numeroSelector);
                            status[6] = false;
                        }
                        checkIfOk();
                    });

                    function isOk(selector){
                        selector.css('border-color', '#abdd92');
                    }

                    function isNotOk(selector){
                        selector.css('border-color', '#f76a6a');
                    }

                    function areAllOk(){
                        for(var i = 0; i < status.length; i++){
                            if(!status[i]){
                                return false;
                            }
                        }
                        return true;
                    }

                    function checkIfOk(){
                        if(areAllOk()){
                            $('#ordina').removeAttr('type').attr('type', 'submit');
                        }else{
                            $('#ordina').removeAttr('type').attr('type', 'button');
                        }
                    }

                    $('#ordina').click(function(){
                        if($('#ordina').attr('type') === 'button'){
                            $('body').append(
                                "<div class=\"alert alert-warning alert-danger fade show padding-footer\" style='margin: 1em;' role=\"alert\">"+
                                "<strong>Errore:</strong> Immetti correttamente tutti i dati."+
                                "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">"+
                                "<span aria-hidden=\"true\">&times;</span>"+
                                "</button>"+
                                "</div>"
                            );
                        }
                    });

                </script>
            </div>
        </form>
    </div>
<?php else: ?>
    <?php echo "Session cart not found"; ?>
<?php endif; ?>
