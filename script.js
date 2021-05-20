function ricordami() {
    let myForm = document.getElementById("logForm");
    let user = myForm.usernameLogin.value;
    let pass = myForm.passLogin.value;

    if (myForm.rememberBox.checked) {
        localStorage.setItem("u", user);
        localStorage.setItem("p", pass);
    }

    return true;
}

function compila() {
    let myForm = document.getElementById("logForm");
    let storedUser = localStorage.getItem("u");
    let storedPassword = localStorage.getItem("p");

    if (storedUser != null && storedPassword != null) {
        myForm.usernameLogin.value = storedUser;
        myForm.passLogin.value = storedPassword;
    }

    return true;
}

function controllaSearch() {
    let myForm = document.getElementById("ricercaEvento");
    let cat = myForm.cercaCategoria.value;
    let dataInit = myForm.cercaDal.valueAsNumber;
    let dataEnd = myForm.cercaAl.valueAsNumber;

    if (cat == "default") {
        let d = document.getElementById("divErroreSearch");
        d.innerHTML = '<div class="alert alert-danger fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attenzione!</strong> Devi scegliere una categoria!</div>';
        d.style.display = "block";
        return false;
    }


    if (dataEnd - dataInit < 0) {
        let d = document.getElementById("divErroreSearch");
        d.innerHTML = '<div class="alert alert-danger fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attenzione!</strong> Le date non sono accettabili!</div>';
        d.style.display = "block";
        return false;
    }

    return true;
}

function controllaSignin() {
    let passwords = document.getElementsByClassName("passSignin");
    if (passwords[0].value == passwords[1].value) return true;

    let d = document.getElementById("divErroreSignin");
    d.innerHTML = '<div class="alert alert-danger fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attenzione!</strong> Le password non coincidono!</div>';
    d.style.display = "block";
    return false;
}


function erroreLogin() {
    $(document).ready(function () {
        $("#myModalLogin").modal("show");

        let user = document.getElementById("usernameLogin");
        let pass = document.getElementById("passLogin");

        user.classList.add("border-danger");
        pass.classList.add("border-danger");

        user.addEventListener("click", function (e) {
            e.target.classList.remove("border-danger");
        });
        pass.addEventListener("click", function (e) {
            e.target.classList.remove("border-danger");
        });
    });
}


function erroreRegistrazione() {
    $(document).ready(function () {
        $("#myModalSignin").modal("show");

        let user = document.getElementById("userSignin");

        user.classList.add("border-warning");

        user.addEventListener("click", function (e) {
            e.target.classList.remove("border-warning");
        });
    });
}

