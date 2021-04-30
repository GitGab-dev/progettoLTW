function validaCreazione(){
    //console.log("VALIDA");
    if (document.getElementById("creaCategoria").value == "default") {
        alert("Scegli la categoria");
        return false;
    }
    else if (document.getElementById("creaTel").value == "" && document.getElementById("creaEmail").value == "") {
        alert("Inserisci un numero di telefono o una email");
        return false;
    }
}

function riempiForm(data){
    document.getElementById("creaNomeEvento").value = data['nome'];
    //Riempimento categoria
    document.getElementById("creaCategoria").selectedIndex = data['categoria'];

    document.getElementById("creaLuogo").value = data['citta'];
    document.getElementById("creaData").value = data['data'];
    document.getElementById("creaOra").value = data['ora'];
    //img
    document.getElementById("creaEmail").value = data['email'];
    document.getElementById("creaTel").value = data['telefono'];
    document.getElementById("creaDesc").value = data['descrizione'];
}