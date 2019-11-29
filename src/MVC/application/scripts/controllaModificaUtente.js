const status = [true, true, true, true, true, true];

//Si riferisce alla lunghezza massima della tabella del DB.
const LUNGHEZZA_MASSIMA_NOME = 50;
const LUNGHEZZA_MASSIMA_COGNOME = 50;
const LUNGHEZZA_MASSIMA_VIA = 50;
const LUNGHEZZA_MASSIMA_CAP = 6;
const LUNGHEZZA_MASSIMA_PAESE = 50;
const LUNGHEZZA_MASSIMA_EMAIL = 255;

function validate(string, maxLen, regex){
    try{
        if(regex === null){
            return (string.length > 0);
        }

        regex = new RegExp(regex);
        string = string.trim();

        if(string.length > 0 && string.length <= maxLen){
            if(regex.test(string)){
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
var nameSelector = $('input[name=nomeMU]');
nameSelector.keyup(function(event){
    if(validate(nameSelector.val(), LUNGHEZZA_MASSIMA_NOME, /^([A-Za-zöäüÖÄÜàèìòùÀÈÌÒÙÉé\. \-])+$/)){
        isOk(nameSelector);
        status[0] = true;
    }else{
        isNotOk(nameSelector);
        status[0] = false;
    }
    checkIfOk();
});

// cognome field
var surnameSelector = $('input[name=cognomeMU]');
surnameSelector.keyup(function(event){
    if(validate(surnameSelector.val(), LUNGHEZZA_MASSIMA_COGNOME, /^([A-Za-zöäüÖÄÜàèìòùÀÈÌÒÙÉé\. \-])+$/)){
        isOk(surnameSelector);
        status[1] = true;
    }else{
        isNotOk(surnameSelector);
        status[1] = false;
    }
    checkIfOk();
});


// via field
var viaSelector = $('input[name=viaMU]');
viaSelector.keyup(function(event){
    if(validate(viaSelector.val(), LUNGHEZZA_MASSIMA_VIA, /^([A-Za-zöäüÖÄÜàèìòùÀÈÌÒÙÉé\. \-0-9])+$/)){
        isOk(viaSelector);
        status[2] = true;
    }else{
        isNotOk(viaSelector);
        status[2] = false;
    }
    checkIfOk();
});

// cap field
var capSelector = $('input[name=capMU]');
capSelector.keyup(function(event){
    if(validate(capSelector.val(), LUNGHEZZA_MASSIMA_CAP, /^([0-9])+$/)){
        isOk(capSelector);
        status[3] = true;
    }else{
        isNotOk(capSelector);
        status[3] = false;
    }
    checkIfOk();
});

// paese field
var paeseSelector = $('input[name=paeseMU]');
paeseSelector.keyup(function(event){
    if(validate(paeseSelector.val(), LUNGHEZZA_MASSIMA_PAESE, /^([A-Za-zöäüÖÄÜàèìòùÀÈÌÒÙÉé \-])+$/)){
        isOk(paeseSelector);
        status[4] = true;
    }else{
        isNotOk(paeseSelector);
        status[4] = false;
    }
    checkIfOk();
});

// email field
var emailSelector = $('input[name=emailMU]');
emailSelector.keyup(function(event){
    if(validate(emailSelector.val(), LUNGHEZZA_MASSIMA_EMAIL, /^([A-Za-zöäüÖÄÜàèìòùÀÈÌÒÙÉé\. \-0-9@])+$/)){
        isOk(emailSelector);
        status[5] = true;
    }else{
        isNotOk(emailSelector);
        status[5] = false;
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
        $('#aggiorna').removeAttr('type').attr('type', 'submit');
    }else{
        $('#aggiorna').removeAttr('type').attr('type', 'button');
    }
}

$('#aggiorna').click(function(){
    if($('#aggiorna').attr('type') === 'button'){
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
