var div = "<div class='spinner-border spinnerMiddle text-dark' role='status' id='spin'>" +
    "           <!-- Gif made by myself on https://loading.io/ -->\n" +
    "           <img src='http://localhost:8888/php/Progetti/PizzaDelivery/src/MVC/scripts/loading.svg' width='80px' height='80px'>\n" +
    "</div>";

$('body').append(div);

$('.container').hide();
$('#spin').show();

$(window).on('load', function(){
    $('#spin').fadeOut('fast');
    $('.container').fadeIn('fast');
});

