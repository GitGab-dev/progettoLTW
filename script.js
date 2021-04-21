function test(){
    let v = document.querySelector(".myFormDiv").style;
    if(v.display=="block") v.display = "none";
    else v.display = "block";
    //document.querySelector(".myFormDiv").style.display = "block";
}