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

function riempiForm(data){
    document.getElementById("creaNomeEvento").value = data['nome'];
    document.getElementById("creaCategoria").selectedIndex = data['categoria'];

    document.getElementById("creaLuogo").value = data['citta'];
    document.getElementById("creaData").value = data['data'];
    document.getElementById("creaOra").value = data['ora'];
    //img
    document.getElementById("myImage").src = "../uploads/" + data['filep'];
    document.getElementById("creaEmail").value = data['email'];
    document.getElementById("creaTel").value = data['telefono'];
    document.getElementById("creaDesc").value = data['descrizione'];
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#myImage').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}