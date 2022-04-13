<?php
require_once "../vendor/autoload.php";
use Services\AllClass\Registratorus;

$registratorus = new Registratorus;



if (isset($_POST['registerbtn'])){
    var_dump("Controller is working");
    $registratorus-> registrationVerificationOrchestrator(
        $_POST["usermail"],
        $_POST["userpwd"], 
        $_POST["userpwdcheck"],
        $_POST["userpseudo"]
    );
}

require_once "../app/views/registration.phtml";