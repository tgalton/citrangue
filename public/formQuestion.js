
// Form -> UNITS
let newUnitName = document.getElementById("newUnitName") ;
let existingUnitName = document.getElementById("existingUnitName") ;
let labelExistingUnitName = document.getElementById("labelExistingUnitName") ;
let unitLvl = document.getElementById("unitLvl") ;
let labelNewUnitName = document.getElementById("labelNewUnitName") ;
let registUnit = document.getElementById("registUnit") ;
let changeUnit = document.getElementById("changeUnit") ;
let errorUnitMsgFromJS = document.getElementById("errorUnitMsgFromJS") ;
var response ;

document.getElementById("unitForm").addEventListener("submit", function(e){
    // Stop the refresh when submit
    e.preventDefault();
    let txtnewNameUnit = document.querySelector("#newUnitName").value ;
    let selectExistingUnitName = document.querySelector("#existingUnitName").value ;
    let lvl = document.querySelector("#unitLvl").value ;
    let myRequest = new Request("../API/formAPI.php", {
        method  : 'POST',
        body : JSON.stringify({
            newNameUnit : txtnewNameUnit,
            existingUnitName : selectExistingUnitName,
            unitLvl : lvl
        })
    })
    fetch(myRequest)


    // .then(console.log(response))
    .then(res => res.text())
    .then(res => {
        response = JSON.parse(res);
        console.log(response)
        if(response["errorGeneralUnitName"] === null && 
        response["errorNewUnitName"] === null && 
        response["errorExistingUnitName"] === null){
            newUnitName.setAttribute("placeholder", response["chosenUnitName"]);
            newUnitName.setAttribute("disabled", "");
            existingUnitName.setAttribute("hidden", "");
            labelExistingUnitName.setAttribute("hidden", "");
            unitLvl.setAttribute("disabled", "");
            labelNewUnitName.innerHTML = "Unité selectionnée";
            registUnit.setAttribute("hidden", "");
            changeUnit.removeAttribute("hidden");
            changeUnit.style.backgroundColor = "blue";
        } else {
            errorUnitMsgFromJS.setAttribute("value", "");
            errorUnitMsgFromJS.innerHTML = response["errorGeneralUnitName"]+"   "+
            response["errorNewUnitName"]+"    "+ 
            response["errorExistingUnitName"];
        }
        return (response);
    })
});

changeUnit.addEventListener("click", function(e){
    e.preventDefault();
    newUnitName.setAttribute("placeholder", "");
    newUnitName.removeAttribute("disabled");
    existingUnitName.removeAttribute("hidden");
    labelExistingUnitName.removeAttribute("hidden");
    unitLvl.removeAttribute("disabled");
    labelNewUnitName.innerHTML = "Nom d'une nouvelle unité";
    registUnit.removeAttribute("hidden");
    changeUnit.setAttribute("hidden", "");
});

// Form -> NOTION

    