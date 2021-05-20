
function controllaSearch(){
    let ricercaEvento = document.getElementById("ricercaEvento")
    let cat = ricercaEvento.cercaCategoria.value;
    let dataInit = ricercaEvento.cercaDal.valueAsNumber;
    let dataEnd = ricercaEvento.cercaAl.valueAsNumber;

    if (cat == "default") {
        let d = document.getElementById("divErroreSearch");
        d.innerHTML='<div class="alert alert-danger fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attenzione!</strong> Devi scegliere una categoria!</div>';
        d.style.display = "block";
        return false;
    }


    if (dataEnd - dataInit < 0) {
        let d = document.getElementById("divErroreSearch");
        d.innerHTML='<div class="alert alert-danger fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attenzione!</strong> Le date non sono accettabili!</div>';
        d.style.display = "block";
        return false;
    }

    return true;
}

