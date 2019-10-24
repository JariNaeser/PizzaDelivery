<div class="container padding-footer text-center">
    <?php if(isset($_SESSION['fattorino']) && count($_SESSION['fattorino']) > 0 && isset($_SESSION['userFattorino']) && count($_SESSION['userFattorino']) > 0): ?>
        <?php $fattorino = $_SESSION['fattorino'][0]; ?>
        <?php $userFattorino = $_SESSION['userFattorino'][0]; ?>
        <h1>FATTORINO "<?php echo $fattorino['username']; ?>"</h1>
        <br>
        <br>
        <div class="row">
            <table class="table table-borderless col-md-6 text-left">
                <tbody>
                <tr>
                    <td><b>Nome</b>: <?php echo $userFattorino['nome']; ?></td>
                </tr>
                <tr>
                    <td><b>Cognome</b>: <?php echo $userFattorino['cognome']; ?></td>
                </tr>
                <tr>
                    <td><b>E-mail</b>: <?php echo $userFattorino['email']; ?></td>
                </tr>
                <tr>
                    <td><b>Via:</b> <?php echo $userFattorino['via']; ?></td>
                </tr>
                <tr>
                    <td><b>Stato:</b> <?php if($fattorino['inServizio'] == 1){
                                                echo "<span class=\"badge badge-danger\">In Servizio</span>";
                                            }else{
                                                echo "<span class=\"badge badge-success\">Libero</span>";
                                            } ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="col-md-6 bg-dark">
                <p class="text-white">Google maps</p>
            </div>
        </div>
        <br>
        <br>
        <h3 class="text-left">Consegne <span style="color: gray;">[<?php echo date("d.m.Y"); ?>]</span></h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ID Consegna</th>
                    <th scope="col">Orario Inserimento</th>
                    <th scope="col">Orario Consegna</th>
                    <th scope="col">Via</th>
                    <th scope="col">Tipologia</th>
                    <th scope="col">Incasso</th>
                </tr>
                </thead>
                <tbody>
                    <?php if(isset($_SESSION['consegneFattorino']) && count($_SESSION['consegneFattorino']) > 0):?>
                        <?php foreach ($_SESSION['consegneFattorino'] as $consegna): ?>
                            <tr>
                                <td class="align-middle"><?php echo $consegna['id'];?></td>
                                <td class="align-middle"><?php echo $consegna['dataInserimento'];?></td>
                                <td class="align-middle"><?php echo $consegna['dataConsegna'];?></td>
                                <td class="align-middle"><?php echo $consegna['via'][0]['via'];?></td>
                                <td class="align-middle"><?php if(strcmp($consegna['tipoConsegna'], "da effettuare") == 0){
                                                echo "<span class='badge badge-danger'>Da Effettuare</span>";
                                            }else if(strcmp($consegna['tipoConsegna'], "in corso") == 0){
                                                echo "<span class='badge badge-warning'>In Corso</span>";
                                            }else{
                                                echo "<span class='badge badge-success'>Terminata</span>";
                                            } ?>
                                </td>
                                <td><?php if(isset($consegna['costoTotale'][0]['SommaCosti'])){
                                                echo $consegna['costoTotale'][0]['SommaCosti'];
                                            }else{
                                                echo "-";
                                            }?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php echo "<tr><td colspan='6'>Nessuna consegna trovata.</td>"; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="<?php echo URL?>fattorini/home" class="btn btn-danger btn-lg">Torna ai fattorini</a>
        </div>
    <?php else: ?>
        <div class="centerVerticallyDiv">
            <h1 class="text-danger">ERRORE: Il fattorino non è stato trovato.</h1>
            <br>
            <a href="<?php echo URL?>fattorini/home" class="btn btn-danger btn-lg">Torna ai fattorini</a>
        </div>
    <?php endif; ?>
</div>