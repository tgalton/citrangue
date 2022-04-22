<?php
require_once "../vendor/autoload.php";
use Services\AllClass\Registratorus;

$registratorus = new Registratorus;

// *** Data user ***
if (isset($_POST['registerbtn'])){
    $registratorus-> registrationVerificationOrchestrator(
        $_POST["usermail"],
        $_POST["userpwd"], 
        $_POST["userpwdcheck"],
        $_POST["userpseudo"]
    );
}

// *** Errors registration ****
$errorGeneral = $registratorus -> registrationsErrors["general"];
$errorPseudo = $registratorus -> registrationsErrors["pseudo"];
$errorPwd = $registratorus -> registrationsErrors["pwd"];
$errorPwdCheck = $registratorus -> registrationsErrors["pwdCheck"];
$errorMail = $registratorus -> registrationsErrors["mail"];

// TODO : use session to keep field when an error occure
require_once "../app/views/registration.phtml";