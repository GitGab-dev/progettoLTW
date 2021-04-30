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
    var data = document.getElementById("creaData").value.split("-").toString();
    data = new Date(data).getTime();
    var dataattuale = new Date().getTime();
    if (data < dataattuale) {
        alert("Inserisci una data valida");
        return false;
    }
}