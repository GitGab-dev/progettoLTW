function apriLogin(){
    let v = document.getElementById("loginFormDiv");
    if(v.style.display=="block") v.style.display = "none";
    else {
        let v2 = document.getElementById("searchFormDiv");
        if(v2.style.display == "block"){
            v2.style.display = "none";
        }
        v.style.display = "block";
        let myForm = v.children[0];
        let storedEmail = localStorage.getItem("e");
        let storedPassword = localStorage.getItem("p");
        if(storedEmail!=null && storedPassword!=null){
            myForm.emailLogin.value = storedEmail;
            myForm.passLogin.value = storedPassword;
        }
    }
}

function apriSearch(){
    let v = document.getElementById("searchFormDiv");
    if(v.style.display=="block") v.style.display = "none";
    else {
        let v2 = document.getElementById("loginFormDiv");
        if(v2.style.display == "block"){
            v2.style.display = "none";
        }
        v.style.display = "block";
    }
}

function controllaLogin(){
    let myForm = document.getElementById("loginFormDiv").firstElementChild;
    let email = myForm.emailLogin.value;
    let pass = myForm.passLogin.value;
    if(!email){
        alert("Inserisci email");
        return false;
    }
    if(!pass){
        alert("Inserisci password");
        return false;
    }

    if(myForm.rememberBox.checked){
        localStorage.setItem("e", email);
        localStorage.setItem("p", pass);
    }

    return true;
}

function controllaSearch(){
    let myForm = document.getElementById("searchFormDiv").firstElementChild;
    let cat = myForm.cercaCategoria.value;
    let dataInit = myForm.cercaDal.valueAsNumber;
    let dataEnd = myForm.cercaAl.valueAsNumber;

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