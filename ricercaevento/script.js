
function controllaSearch(){
    let ricercaEvento = document.getElementById("ricercaEvento")
    let cat = ricercaEvento.cercaCategoria.value;
    let dataInit = ricercaEvento.cercaDal.valueAsNumber;
    let dataEnd = ricercaEvento.cercaAl.valueAsNumber;

    if (cat == "default") {
        alert("Scegli la categoria");
        return false;
    }


    if(dataEnd - dataInit < 0) {
        alert("Le date non sono accettabili");
        return false;
    }

    return true;
}

