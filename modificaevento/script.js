function validaCreazione() {
    if (document.getElementById("creaCategoria").value == "default") {
        let d = document.getElementById("divErroreCrea");
        d.innerHTML = '<div class="alert alert-danger fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attenzione!</strong> Devi scegliere una categoria!</div>';
        d.style.display = "block";
        return false;
    }
    else if (document.getElementById("creaTel").value == "" && document.getElementById("creaEmail").value == "") {
        let d = document.getElementById("divErroreCrea");
        d.innerHTML = '<div class="alert alert-danger fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attenzione!</strong> Devi scegliere un numero di telefono o una password!</div>';
        d.style.display = "block";
        return false;
    }
    var data = document.getElementById("creaData").value.split("-").toString();
    data = new Date(data).getTime();
    var dataattuale = new Date().getTime();
    if (data < dataattuale) {
        let d = document.getElementById("divErroreCrea");
        d.innerHTML = '<div class="alert alert-danger fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attenzione!</strong> Devi inserire una data valida!</div>';
        d.style.display = "block";
        return false;
    }
}

function riempiForm(data) {
    document.getElementById("creaNomeEvento").value = data['nome'];
    document.getElementById("creaCategoria").selectedIndex = data['categoria'];
    document.getElementById("creaLuogo").value = data['citta'];
    document.getElementById("creaData").value = data['data'];
    document.getElementById("creaOra").value = data['ora'];
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