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

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#myImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

