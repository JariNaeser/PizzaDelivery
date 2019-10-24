<div class="col-md-12 text-center centerVerticallyDiv" id="content">
    <h1>Benvenuto da <br> <span class="text-danger">PizzaDelivery</span></h1>
    <p>Hai fame? Ecco la soluzione per te, ordina e ricevi in <br> breve tempo la tua pizza preferita.</p>
    <a href="<?php echo URL?>ordina/home" class="btn btn-danger btn-lg">Ordina ora</a>
</div>

<div class="spinner-border spinnerMiddle text-dark" role="status" id="spin">
    <span class="sr-only">Loading...</span>
    <img src="https://media.giphy.com/media/IwSG1QKOwDjQk/source.gif">
</div>

<script>
    $('#content').hide();
    $('#spin').show();
    $(window).on('load', function(){

        $('#spin').fadeOut('slow');
        $('#content').fadeIn('slow');
    });
</script>




