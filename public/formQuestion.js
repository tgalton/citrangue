
// Form -> UNITS
let newUnitName = document.getElementById("newUnitName") ;
let existingUnitName = document.getElementById("existingUnitName") ;
let labelExistingUnitName = document.getElementById("labelExistingUnitName") ;
let unitLvl = document.getElementById("unitLvl") ;
let labelNewUnitName = document.getElementById("labelNewUnitName") ;
let registUnit = document.getElementById("registUnit") ;
let changeUnit = document.getElementById("changeUnit") ;
let errorUnitMsgFromJS = document.getElementById("errorUnitMsgFromJS") ;
let registNotion = document.getElementById("registNotion") ;
let existingNotionName = document.getElementById("existingNotionName") ;
let response ;

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
            // If Unit is OK -> freeze selection.
            newUnitName.setAttribute("placeholder", response["chosenUnitName"]);
            newUnitName.setAttribute("disabled", "");
            existingUnitName.setAttribute("hidden", "");
            labelExistingUnitName.setAttribute("hidden", "");
            unitLvl.setAttribute("disabled", "");
            labelNewUnitName.innerHTML = "Unité selectionnée";
            registUnit.setAttribute("hidden", "");
            changeUnit.removeAttribute("hidden");
            changeUnit.style.backgroundColor = "blue";
            // Should add notion corresponding to Unit's ID selected.
            let availableNotions = response["availableNotions"] ;
            for(let i = 0; i< availableNotions.lenght; i++) {
                var option = document.createElement("option");
                option.text = availableNotions[i-1];
                existingNotionName.add(option, existingNotionName[i-1]);
            }
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
    // Disable avaibles notions
});

// Form -> NOTION
document.registNotion.addEventListener("submit", function(e){

}
    