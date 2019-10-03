<div class="container padding-footer text-center">
    <?php $ordine = $_SESSION['ordine']; ?>
    <h1>ORDINAZIONE #<?php echo $ordine[0][0]['id'] ?></h1>
    <pre>
        <?php print_r($ordine); ?>
    </pre>

    <h1 class="text-danger">METTERE A POSTO import file CSS (solo in questa classe).</h1>

    <a href="<?php echo URL?>home/ordinazioni" class="btn btn-danger btn-lg">Torna agli ordini</a>
</div>