function apriForm(){
    let v = document.querySelector(".myFormDiv");
    if(v.style.display=="block") v.style.display = "none";
    else {
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

function controllaLogin(){
    let myForm = document.querySelector(".myForm");
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