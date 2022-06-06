
// Form -> UNITS
// let most of html elements
let unitForm = document.getElementById("unitForm") ;
let newUnitName = document.getElementById("newUnitName") ;
let existingUnitName = document.getElementById("existingUnitName") ;
let labelExistingUnitName = document.getElementById("labelExistingUnitName") ;
let unitLvl = document.getElementById("unitLvl") ;
let labelNewUnitName = document.getElementById("labelNewUnitName") ;
let registUnit = document.getElementById("registUnit") ;
let changeUnit = document.getElementById("changeUnit") ;
let errorUnitMsgFromJS = document.getElementById("errorUnitMsgFromJS") ;
let existingNotionName = document.getElementById("existingNotionName") ;
let saveUnitID = document.getElementById("saveUnitID") ;
let saveLvlID = document.getElementById("saveLvlID") ;
const inpFile = document.getElementById("inpFile") ;
let uploadedImage = "" ;
let response ;

document.getElementById("unitForm").addEventListener("submit", function(e){
    // Stop the refresh when submit
    e.preventDefault();

    //Request for ImageUnit 
    // const formData = new FormData(unitForm);
    // console.log(formData) ;
    // formData.append("file", inpFile.files[0]);
    // console.log(inpFile.files[0]) ;
    

    // const lastModified = inpFile.files[0]["lastModified"] ;
    // const name = inpFile.files[0]["name"] ;
    // const size = inpFile.files[0]["size"] ;
    // const type = inpFile.files[0]["type"] ;
    // const webkitRelativePath = inpFile.files[0]["webkitRelativePath"] ;

    // // formData.append("inpFile", inpFile.files[0]) ;
    // let myRequest = new Request("../API/uploadImage.php", {
    //     method  : 'POST',
    //     body : JSON.stringify({
    //         lastModified : lastModified, 
    //         name : name,
    //         size : size,
    //         type : type,
    //         webkitRelativePath: webkitRelativePath
    //     })
    // })
    // fetch(myRequest) ;


    
    // fetch(endpoint, {
    //     method : "post",
    //     body: formData
    // }).catch(console.error);



    // Request for Unit
    let txtnewNameUnit = document.querySelector("#newUnitName").value ;
    let selectExistingUnitName = document.querySelector("#existingUnitName").value ;
    let lvl = document.querySelector("#unitLvl").value ;
    let myRequest = new Request("../API/unitFormAPI.php", {
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
        if(response["errorGeneralUnitName"] === null && 
        response["errorNewUnitName"] === null && 
        response["errorExistingUnitName"] === null){
            // If Unit is OK -> freeze selection.
            newUnitName.setAttribute("placeholder", response["chosenUnitName"]) ;
            newUnitName.setAttribute("disabled", "") ;
            existingUnitName.setAttribute("hidden", "") ;
            labelExistingUnitName.setAttribute("hidden", "") ;
            unitLvl.setAttribute("disabled", "") ;
            labelNewUnitName.innerHTML = "Unité selectionnée" ;
            registUnit.setAttribute("hidden", "") ;
            changeUnit.removeAttribute("hidden") ;
            changeUnit.style.backgroundColor = "blue" ;
            saveUnitID.setAttribute("value", response["chosenUnitID"]) ;
            saveLvlID.setAttribute("value", response["lvlId"]["level_id"]) ;


            // Should add notion corresponding to Unit's ID selected.
            let availableNotions = response["availableNotions"] ;
            for (let i = 0; i < availableNotions.length; i++) {
                let opt = document.createElement("option");
                // console.log(availableNotions[i]["notion_id"]);
                opt.value = availableNotions[i]["notion_name"];
                opt.text = availableNotions[i]["notion_name"];
                existingNotionName.add(opt, null);
            }
            // for(let i = 0; i< availableNotions.lenght; i++) {
            //     var option = document.createElement("option");
            //     option.text = availableNotions[i-1];
            //     existingNotionName.add(option, existingNotionName[i-1]);
            // }


        } else {
            errorUnitMsgFromJS.setAttribute("value", "");
            errorUnitMsgFromJS.innerHTML = response["errorGeneralUnitName"]+"   "+
            response["errorNewUnitName"]+"    "+ 
            response["errorExistingUnitName"];
        }
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
// Define both field
let notionForm= document.getElementById("notionForm") ;
let newNotionName = document.getElementById("newNotionName") ;
let labelNewNotionName = document.getElementById("labelNewNotionName") ;
let selectedNotionName = document.getElementById("existingNotionName") ;
let labelExistingNotionName = document.getElementById("labelExistingNotionName") ;
let registNotion = document.getElementById("registNotion") ;
let changeNotion = document.getElementById("changeNotion") ;
let errorNotionMsgFromJS = document.getElementById("errorNotionMsgFromJS") ;
let saveNotionID = document.querySelector('#saveQuestionID') ;
// let registNotion = document.querySelector("registNotion") ;


document.getElementById("notionForm").addEventListener("submit", function(e){
    // Stop the refresh when submit
    e.preventDefault();
    // let param for fetch
    let txtnewNameNotion = newNotionName.value ;
    let selectNotion = document.querySelector("#existingNotionName").value ;
    let unitID = saveUnitID.getAttribute("value") ;
    let lvlID = saveLvlID.getAttribute("value") ;
    let myRequest = new Request("../API/notionFormAPI.php", {
        method  : 'POST',
        body : JSON.stringify({
            newNameNotion : txtnewNameNotion,
            existingNotionName : selectNotion,
            unitIDToPush : unitID,
            lvlIDToPush :  lvlID
        })
    })

    fetch(myRequest) 
    .then(res => res.text())
    .then(res => {
        response = JSON.parse(res);

        // If Notion -> is OK :
        if(response["errorGeneralNotionName"] === null && 
        response["errorNewNotionName"] === null && 
        response["errorExistingNotionName"] === null)
        {
            // Freeze notion choice
            newNotionName.setAttribute("placeholder", response["chosenNotionName"]) ;
            newNotionName.setAttribute("disabled", "") ;
            // Change title
            labelNewNotionName.innerHTML = "Notion choisie" ;
            // Hide choice.
            labelExistingNotionName.setAttribute("hidden", "");
            selectedNotionName.setAttribute("hidden", "");
            labelExistingNotionName.setAttribute("hidden", "");
            // Hide the register button
            registNotion.setAttribute("hidden", "");
            // Show the change notion button
            changeNotion.removeAttribute("hidden") ;
            changeNotion.style.backgroundColor = "blue" ;
            // Save notion ID
            saveNotionID.value = response["chosenNotionID"]

        // If not working ->
        } else {
            // Show errors logs
            errorNotionMsgFromJS.setAttribute("value", "");
            errorNotionMsgFromJS.innerHTML = response["errorGeneralNotionName"]+"   "+
            response["errorNewNotionName"]+"    "+ 
            response["errorExistingNotionName"];
        }
    })
})


// Form -> Question & Answers
// let txtNewQuestion = document.getElementById("txtNewQuestion") ;
let saveQuestionID = document.getElementById("saveQuestionID") ;
let timeRequire = document.getElementById("timeRequire") ;
let errorQuestionMsgFromJS = document.getElementById("errorQuestionMsgFromJS") ;

document.getElementById("questionForm").addEventListener("submit", function(e){

    // Stop the refresh when submit
    e.preventDefault();

    // Send data for the question
    let notionID = saveNotionID.value;
    // TODO : Improve the app by adding differents types of question
    // and possibility to use images. 
    let questionTypeID = 1;
    let illustrated = 0;
    let timeRequireAmount = timeRequire.value ;
    let txtNewQuestion = document.getElementById("txtNewQuestion").value ;
    // let lvl = document.querySelector("#unitLvl").value ;
    let myRequestForQuestion = new Request("../API/questionFormAPI.php", {
        method  : 'POST',
        body : JSON.stringify({
            // data for Question
            notionID :notionID,
            questionTypeID :questionTypeID,
            illustrated : illustrated,
            timeRequireAmount : timeRequireAmount,
            txtNewQuestion :txtNewQuestion
        })
    })
    fetch(myRequestForQuestion) 
    .then(res => res.text())
    .then(res => {
        response = JSON.parse(res) ;
        if(response["errorQuestionText"] === null){
            document.querySelector('#saveQuestionID').value = response["questionID"]
            saveQuestionID.value = response["questionID"] ;
        } else {
            errorQuestionMsgFromJS.removeAttribute("hidden");
            errorQuestionMsgFromJS.innerHTML = response["errorQuestionText"];
        }
    })


    // Function to send data for answers
    function fetchOneAnswer(txtNewAnswer, isCorrect) {
        let QuestionID = saveQuestionID.value ;
        // console.log(txtNewAnswer, isCorrect, QuestionID) ;
        let myRequestForAnswer = new Request("../API/answerFormAPI.php", {
            method  : 'POST',
            // data Answer
            body : JSON.stringify({
                txtNewAnswer : txtNewAnswer,
                isCorrect : isCorrect,
                QuestionID : QuestionID
            })
        })
        fetch(myRequestForAnswer)
        .then(res => res.text())
        .then(res => {
            response = JSON.parse(res) ;
        });
    }

    // Send data for the answers.
    // Answer 1 :
    let txtAnswer1 = document.getElementById("txtAnswer1").value ;
    let isItTrue1 = document.getElementById("isItTrue1").value ;
    fetchOneAnswer(txtAnswer1, isItTrue1) ;
    // Answer 2 :
    let txtAnswer2 = document.getElementById("txtAnswer2").value ;
    let isItTrue2 = document.getElementById("isItTrue2").value ;
    fetchOneAnswer(txtAnswer2, isItTrue2) ;
    // Answer 3 :
    let txtAnswer3 = document.getElementById("txtAnswer3").value ;
    let isItTrue3 = document.getElementById("isItTrue3").value ;
    fetchOneAnswer(txtAnswer3, isItTrue3) ;
    // Answer 4 :
    let txtAnswer4 = document.getElementById("txtAnswer4").value ;
    let isItTrue4 = document.getElementById("isItTrue4").value ;
    fetchOneAnswer(txtAnswer4, isItTrue4) ;



});
