<?php
require_once "../vendor/autoload.php";
use Services\AllClass\Registratorus;

$registratorus = new Registratorus;
if (isset($_POST['submitNewUser'])){
    $registratorus-> registrationVerificationOrchestrator(
        $_POST['usermail'],
        $_POST['userpwr'], 
        $_POST['userpwrverif'],
        $_POST['username']
    );
}


require_once "../app/views/registration.phtml";