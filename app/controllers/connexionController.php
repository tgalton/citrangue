<?php
require_once "../vendor/autoload.php";
use Services\AllClass\UserConnectatorus;

$registratorus = new UserConnectatorus;

// *** Data user ***
if (isset($_POST['connexionbtn'])){
    $registratorus-> registrationVerificationOrchestrator(
        $_POST["usermail"],
        $_POST["userpwd"], 
    );
}

// *** Errors registration ****
$errorGeneral = $registratorus -> registrationsErrors["general"];
$errorPwd = $registratorus -> registrationsErrors["pwd"];
$errorMail = $registratorus -> registrationsErrors["mail"];

require_once "../app/views/connexion.phtml";