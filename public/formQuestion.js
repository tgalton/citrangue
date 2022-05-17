// document.getElementById("unitForm").addEventListener("submit", function(e){
//     e.preventDefault();
//     var xhr = new XMLHttpRequest();

//     xhr.onreadystatechange = function() {
//         if(this.readyState == 4 && this.status == 200) {
//             console.log(this.response);
//         } else if (this.readyState == 4) {
//             alert ("Une erreur est survenue ...");
//         }
//     };

//     xhr.open("GET", "../App/API/formAPI.php", true);
//     xhr.send();
    
//     return false;
// });