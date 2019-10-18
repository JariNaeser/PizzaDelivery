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
                <th scope="col">ID Ordinazione</th>
                <th scope="col">Fattorino</th>
                <th scope="col">Data</th>
                <th scope="col">TipoConsegna</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($consegne) && count($consegne) > 0): ?>
                <?php foreach ($consegne as $consegna): ?>
                    <?php echo "<tr><td>" . $consegna['id'] . "</td><td>" . $consegna['ordinazione'] . "</td><td>" . $consegna['fattorino'] . "</td><td>"; if(isset($consegna['data'])){echo $consegna['data'];}else{echo "-";} echo "</td><td>"; ; if(strcmp($consegna['tipoConsegna'], "da effettuare") == 0){echo "<span class='badge badge-danger'>Da Effettuare</span>"; }else if(strcmp($consegna['tipoConsegna'], "in corso") == 0){echo "<span class='badge badge-warning'>In Corso</span>"; }else{echo "<span class='badge badge-success'>Terminata</span>"; } echo "</td></tr>"; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php echo "<tr><td colspan='5'>Nessuna consegna trovata.</td></tr>"; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script>
        jQuery(document).ready(function($) {

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

    </script>
</div>

