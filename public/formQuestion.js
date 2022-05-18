
// Form -> UNITS
document.getElementById("unitForm").addEventListener("submit", function(e){
    // Stop the refresh when submit
    e.preventDefault();
    
    let myRequest = new Request("../App/API/formAPI.php", {
        method  : 'POST',
    })
    fetch(myRequest);



    // FormData can take all the entries form form (Unit)
    // var data = new FormData(this);

    // var xhr = new XMLHttpRequest();

    // xhr.onreadystatechange = function() {
    //     if(this.readyState == 4 && this.status == 200) {
    //         console.log(this.response);
    //     } else if (this.readyState == 4) {
    //         alert ("Une erreur est survenue ...");
    //     }
    // };

    // xhr.open("POST", "../App/API/formAPI.php", true);
    // xhr.responseType = "json";
    
    // xhr.send(data);
    
    // return false;
});