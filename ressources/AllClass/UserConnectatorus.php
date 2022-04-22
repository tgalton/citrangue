<?php
namespace Services\allClass;
use Services\AllClass\DataFinder;
// This class is use to connect a new user.
// All the rules and verifications for mail, password are centralize
// and coordinate here.

class UserConnectatorus {
    public $registrationsErrors = [
        "general" => NULL,
        "pwd" => NULL,
        "mail" => NULL
    ];

    public $resultReturned = TRUE;

    public CONST PATTERN_MAIL = '/^\S+@\S+\.\S+$/';
    public CONST PATTERN_PWD = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/';

    public function registrationVerificationOrchestrator(
        $userMail,
        $userPwd,
    )
    {
        if(empty($userMail) || empty($userPwd))
        {
            // if all the field are not completed, we save an error.
            $this -> registrationsErrors["general"] = "Les champs ne sont pas tous complets" ;
            // and turn $resultReturned into false.
            $this -> resultReturned = FALSE;
        } else {
            $dataFinder = new DataFinder();
            if($dataFinder -> isThisMailAlreadyExist($userMail)){
            //     // If it already exist, run further verification -> is it the right pwd ?
                $result = $dataFinder-> findUserByMail($userMail);
                
            } else {
            // Else return error and false
            $this -> registrationsErrors["general"] = "Le mot de passe ou le mail est incorrect";
            $this -> resultReturned = FALSE;
            }
        }
    }
        
}