function ricorda(){
        let myForm = document.getElementById("logForm");
        let storedEmail = localStorage.getItem("e");
        let storedPassword = localStorage.getItem("p");
        if(storedEmail!=null && storedPassword!=null){
            myForm.emailLogin.value = storedEmail;
            myForm.passLogin.value = storedPassword;
        }
    
}


function controllaLogin(){
    let myForm = document.getElementById("logForm");
    let email = myForm.emailLogin.value;
    let pass = myForm.passLogin.value;

    if(myForm.rememberBox.checked){
        localStorage.setItem("e", email);
        localStorage.setItem("p", pass);
    }

    return true;
}

function controllaSearch(){
    let myForm = document.getElementById("ricercaEvento");
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

function removeClass(e){
    console.log(e);
    e.target.classList.remove("border-danger");
}

function erroreLogin(){
    document.getElementById("loginFormDiv").style.display = "block";

    let email = document.getElementById("emailLogin")

    email.classList.add("border-danger");
    email.addEventListener("click",removeClass);

    let pass = document.getElementById("passLogin")
    pass.classList.add("border-danger");
    pass.addEventListener("click",removeClass);
}
