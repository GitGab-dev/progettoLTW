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