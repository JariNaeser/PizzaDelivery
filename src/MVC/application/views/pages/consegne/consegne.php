<div class="container padding-footer text-center">
    <h1>CONSEGNE</h1>
    <br>
    <pre><?php print_r($_SESSION['consegne']); ?></pre>
    <div class="form-group float-center" align="center">
        <label for="exampleFormControlSelect1">Fino a</label>
        <select class="form-control col-md-3" id="selectTime">
            <option>Tutte</option>
            <option>Questa settimana</option>
            <option>2 settimane fa</option>
            <option>3 settimane fa</option>
            <option>1 mese fa</option>
            <option>6 mesi fa</option>
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
            <?php if(isset($_SESSION['consegne']) && count($_SESSION['consegne']) > 0): ?>
                <?php foreach ($_SESSION['consegne'] as $consegna): ?>
                    <?php echo "<tr><td>" . $consegna['id'] . "</td><td>" . $consegna['ordinazione'] . "</td><td>" . $consegna['fattorino'] . "</td><td>" . $consegna['data'] . "</td><td>"; ; if(strcmp($consegna['tipoConsegna'], "da effettuare") == 0){echo "<span class='badge badge-danger'>Da Effettuare</span>"; }else if(strcmp($consegna['tipoConsegna'], "in corso") == 0){echo "<span class='badge badge-warning'>In Corso</span>"; }else{echo "<span class='badge badge-success'>Terminata</span>"; } echo "</td></tr>"; ?>
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
            }).done(function (res) {
                document.open();
                document.write(res);
                document.close();
            });
        }

    </script>
</div>

