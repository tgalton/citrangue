<?php
namespace Services\allClass;
use Services\AllClass\DataFinder;
// This class is use to register a new user.
// All the rules and verifications for mail, password and pseudo are centralize
// and coordinate here.

class Registratorus {
    // $registrationsErrors save errors that should appear.
    public $registrationsErrors = [
        "general" => NULL,
        "pseudo" => NULL,
        "pwd" => NULL,
        "pwdCheck" => NULL
    ];

    // $resultReturned save the result at each step of verification
    // if all the revification return true, $resultReturned is true
    // otherwise it is false and we don't push the new user into database.
    public $resultReturned = TRUE;

    // Declaration of all the regex patterns
    CONST patternMail = '/^\S+@\S+\.\S+$/';
    CONST patternPwd = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/';
    CONST patternPseudo = '/^[\w\d\-]{1,45}$/';


    public function registrationVerificationOrchestrator(
        $userMail,
        $userPwd,
        $userPwdCheck,
        $userPseudo
    )
    // This function will lead the verification of input and, if they are correct
    //  push them to the next step -> database.
    {
        // We verify if all the field are completed.
        if(empty($userMail) || empty($userPwd) || empty($userPwdCheck) || empty($userPseudo)) {
            // if all the field are not completed, we save an error.
            $this -> registrationsErrors["general"] = "Les champs ne sont pas tous complets" ;
            // and turn $resultReturned into false.
            $this -> resultReturned = FALSE;
        };

        // If $resultReturned is True, pseudoVerication is OK, $resultReturned still True
        $resultReturned = $this->pseudoVerificator() && $resultReturned ;
        
        
        // If $resultReturned = FALSE, don't push.
        if($this -> resultReturned){
        $this-> loadPushNewUser($userPseudo, $userMail, $userPwd);
        }
    }
    public function pseudoVerificator()
    {
        return TRUE;
    }
    public function mdpVerificator()
    {
        // ** Verification of mdp
        // If mdp is undefined, the script stop and return an error

    }
    public function mailVerificator()
    {
    }
    // pushNewUser : this method is call from registrationController
    public function loadPushNewUser($userName, $userMail, $userMdp)
    {
        // On utilise la méthode push est présente dans la class datafinder.
        $dataFinder = new DataFinder();
        $dataFinder -> pushNewUser($userName, $userMail, $userMdp);
    }
}