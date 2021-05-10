function ricorda() {
    let myForm = document.getElementById("logForm");
    let storeduser = localStorage.getItem("e");
    let storedPassword = localStorage.getItem("p");
    if (storeduser != null && storedPassword != null) {
        myForm.usernameLogin.value = storeduser;
        myForm.passLogin.value = storedPassword;
    }

}


function controllaLogin() {
    let myForm = document.getElementById("logForm");
    let user = myForm.usernameLogin.value;
    let pass = myForm.passLogin.value;

    if (myForm.rememberBox.checked) {
        localStorage.setItem("e", user);
        localStorage.setItem("p", pass);
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

function controllaSignin() {
    if (document.getElementById("passSignin").value == document.getElementById("passSigninBis").value) return true;
    let d = document.getElementById("divErroreSignin");
    d.innerHTML='<div class="alert alert-danger fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Attenzione!</strong> Le password non coincidono!</div>';
    d.style.display = "block";
    return false;
}

function removeClass(e) {
    console.log(e);
    e.target.classList.remove("border-danger");
}

function erroreLogin() {
    $(document).ready(function () {
        $("#myModalLogin").modal("show");

        let user = document.getElementById("usernameLogin");
        console.log(user);

        user.classList.add("border-danger");
        user.addEventListener("click", removeClass);

        let pass = document.getElementById("passLogin");
        pass.classList.add("border-danger");
        pass.addEventListener("click", removeClass);
    });
}

function removeClassR(e) {
    console.log(e);
    e.target.classList.remove("border-warning");
}

function erroreRegistrazione() {
    $(document).ready(function () {
        $("#myModalSignin").modal("show");

        let user = document.getElementById("userSignin");
        console.log(user);

        user.classList.add("border-warning");
        user.addEventListener("click", removeClassR);

    });
}

