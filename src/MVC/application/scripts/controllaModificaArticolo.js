const status = [true, true, true, true];

//Si riferisce alla lunghezza massima della tabella del DB.
const LUNGHEZZA_MASSIMA_NOME = 50;
const LUNGHEZZA_MASSIMA_DESCRIZIONE = 255;
const LUNGHEZZA_MASSIMA_PREZZO = 6;
const LUNGHEZZA_MASSIMA_NOME_IMMAGINE = 255;

function validate(string, maxLen, regex){
    try{
        if(regex === null){
            return (string.length > 0);
        }
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
var nameSelector = $('input[name=nomeMA]');
nameSelector.change(function(event){
    if(validate(nameSelector.val(), LUNGHEZZA_MASSIMA_NOME, /([^A-Za-zöäüÖÄÜàèìòùÀÈÌÒÙÉé -.])/)){
        isOk(nameSelector);
        status[0] = true;
    }else{
        isNotOk(nameSelector);
        status[0] = false;
    }
    checkIfOk();
});

// descrizione field
var descriptionSelector = $('input[name=descrizioneMA]');
descriptionSelector.change(function(event){
    if(validate(descriptionSelector.val(), LUNGHEZZA_MASSIMA_DESCRIZIONE, /([^A-Za-zöäüÖÄÜàèìòùÀÈÌÒÙÉé -.0-9])/)){
        isOk(descriptionSelector);
        status[1] = true;
    }else{
        isNotOk(descriptionSelector);
        status[1] = false;
    }
    checkIfOk();
});


// prezzo field
var priceSelector = $('input[name=prezzoMA]');
priceSelector.change(function(event){
    if(validate(priceSelector.val(), LUNGHEZZA_MASSIMA_PREZZO, /([^0-9.,])/)){
        isOk(priceSelector);
        status[2] = true;
    }else{
        isNotOk(priceSelector);
        status[2] = false;
    }
    checkIfOk();
});

// path field
var pathSelector = $('input[name=pathImmaginaMA]');
pathSelector.change(function(event){
    if(pathSelector.val().length <= LUNGHEZZA_MASSIMA_NOME_IMMAGINE){
        isOk(pathSelector);
        status[3] = true;
    }else{
        isNotOk(pathSelector);
        status[3] = false;
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
        $('#aggiornaArticolo').removeAttr('type').attr('type', 'submit');
    }else{
        $('#aggiornaArticolo').removeAttr('type').attr('type', 'button');
    }
}

$('#aggiornaArticolo').click(function(){
    if($('#aggiornaArticolo').attr('type') === 'button'){
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
