const status = [false, false, false, false, false, false, false];

//Si riferisce alla lunghezza massima della tabella del DB.
const LUNGHEZZA_MASSIMA_NOME = 50;
const LUNGHEZZA_MASSIMA_COGNOME = 50;
const LUNGHEZZA_MASSIMA_TELEFONO = 20;
const LUNGHEZZA_MASSIMA_VIA = 44;       //Con aggiunta di numero, 50 - 5 - 1(spazio) = 44
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
nameSelector.keyup(function(event){
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
surnameSelector.keyup(function(event){
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
paeseSelector.keyup(function(event){
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
var telefonoSelector = $('input[name=numeroTelefono]');
telefonoSelector.keyup(function(event){
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
viaSelector.keyup(function(event){
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
capSelector.keyup(function(event){
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
numeroSelector.keyup(function(event){
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
