<div class="container padding-footer text-center">
    <h1>CONSEGNE</h1>
    <br>
    <div class="form-group float-center" align="center">
        <label for="exampleFormControlSelect1">Fino a</label>
        <select class="form-control col-md-3" id="selectTime">
            <option>Questa settimana</option>
            <option>2 settimane fa</option>
            <option>3 settimane fa</option>
            <option>1 mese fa</option>
            <option>6 mesi fa</option>
            <option>Tutte</option>
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

            <?php else: ?>
                <?php echo "<tr><td colspan='5'>Nessuna consegna trovata.</td></tr>"; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php echo "Number: " . $_SESSION['number']; ?>

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
                        setWeeks(1);
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

