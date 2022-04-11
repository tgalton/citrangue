<?php
namespace Services\allClass;
use Services\AllClass\DataFinder;
// This class is use to register a new user.
// All the rules and verifications for mail, password and pseudo are centralize
// and coordinate here.

class Registratorus {
    // $registrationsErrors save errors that should appear.
    public $registrationsErrors = [
        "general" => NULL
    ];
    // $resultReturned save the result at each step of verification
    // if all the revification return true, $resultReturned is true
    // otherwise it is false and we don't push the new user into database.
    public $resultReturned = TRUE;




    public function registrationVerificationOrchestrator(
        $userPseudo,
        $userMdp,
        $userPwrVerif,
        $userMail
    )
    // This function will lead the verification of input and, if they are correct
    //  push them to the next step -> database.
    {
        // We verify if all the field are completed.
        if(!isset($userPseudo, $$userMdp, $userPwrVerif, $userMail)){
          $registrationsErrors["general"] = "Les champs ne sont pas tous complets" ;
        }

        // $resultReturned = if($resultReturned === TRUE && $this->pseudoVerificator();
        // if all the field are not completed, we save an error
        // and turn $resultReturned into false.
        $this-> loadPushNewUser($userName, $userMail, $userMdp);
    }
    public function pseudoVerificator()
    {
        // ** Verification of pseudo
        // TODO : faire ça avec un match
        // If pseudo is not define, the script stop and return an error.
        if(empty($_POST['pseudo']))
        {
            echo "Le pseudo n'est pas renseigné.";
        }
        // Stop and return error if pseudo contain specials char.
        elseif(!preg_match("^([a-zA-Z0-9-_]{2,36})$", $pseudo,$_POST['pseudo']))
        {
            echo "Le pseudo ne doit pas comprendre de caractères spéciaux";
        }
        // Stop and return error if pseudo is too long
        elseif(strlen($_POST['pseudo'])>40)
        {
            echo "Le pseudo ne doit pas faire plus de 40 caractères";
        }

        
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