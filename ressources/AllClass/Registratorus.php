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
        "pwdCheck" => NULL,
        "mail" => NULL
    ];

    // $resultReturned save the result at each step of verification
    // if all the revification return true, $resultReturned is true
    // otherwise it is false and we don't push the new user into database.
    public $resultReturned = TRUE;

    // Declaration of all the regex patterns
    public CONST PATTERN_MAIL = '/^\S+@\S+\.\S+$/';
    public CONST PATTERN_PWD = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/';
    public CONST PATTERN_PSEUDO = '/^[\w\d\-]{1,45}$/';


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

        // Instanciate dataFinder to check later if Pseudo and Mail already exist into database.
        $dataFinder = new DataFinder();

        // If $resultReturned is True, pseudoVerication is OK, $resultReturned still True
        $this->resultReturned = $this->pseudoVerificator($userPseudo) && $this->resultReturned ;
        // Same here with pwd
        $this->resultReturned = $this->pwdVerificator($userPwd) && $this->resultReturned ;
        // Same here with pwdCheck
        $this->resultReturned = $this->pwdCheckVerificator($userPwd, $userPwdCheck) && $this->resultReturned ;
        
        
        // If $resultReturned = FALSE, don't push.
        if($this -> resultReturned){
        $this-> loadPushNewUser($userPseudo, $userMail, $userPwd);
        }
    }

    public function pseudoVerificator($userPseudo)
    {
        // If match is okay and userPseudo don't exist already, return TRUE; else return FALSE
        // and save the correct error message.
        $dataFinder = new DataFinder();
        if(preg_match(self::PATTERN_PSEUDO, $userPseudo)){
            if($dataFinder -> isThisPseudoAlreadyExist($userPseudo)){
                $this -> registrationsErrors["pseudo"] = "Ce pseudo existe déjà";
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            $this -> registrationsErrors["pseudo"] = "Votre pseudo ne doit pas contenir .!@#$%^&* ";
            return FALSE;
        };
        
    }

    public function pwdVerificator($userPwd)
    {
        if(preg_match(self::PATTERN_PWD, $userPwd)){
            return TRUE;
        } else {
            $this -> registrationsErrors["pwd"] = "Votre mot de passe doit faire au moins 8 charactères et posséder un chiffre, une majuscule et un charactère spécial. Nous vous recommendons d'utiliser une phrase.";
            return FALSE;
        };


    }

    public function pwdCheckVerificator($userPwd, $userPwdCheck)
    {
        if($userPwd === $userPwdCheck){
            return TRUE;
        } else {
            $this -> registrationsErrors["pwdCheck"] = "Vous devez répéter le même mot de passe.";
            return FALSE;
        };      
    }

    public function mailVerificator($userMail)
    {
        // If the mail inserted have the correct pattern and don't already exist in the users database, return TRUE. 
        if (preg_match(self::PATTERN_MAIL, $userMail)){
            if($dataFinder -> isThisMailAlreadyExist($userMail)){
                return TRUE;
            } else {
                $this -> registrationsErrors["mail"] = "Ce mail est déjà utilisé";
                return FALSE;
            }
        } else {
            $this -> registrationsErrors["mail"] = "Veuillez utiliser un mail valide";
            return FALSE;
        }
    }

    // pushNewUser : this method is call from registrationController
    public function loadPushNewUser($userName, $userMail, $userMdp)
    {
        $options = [
            'cost' => 12,
        ];
        $userMdpHashed = password_hash($userMdp, PASSWORD_BCRYPT, $options);
        // On utilise la méthode push est présente dans la class datafinder.
        $dataFinder = new DataFinder();
        $dataFinder -> pushNewUser($userName, $userMail, $userMdpHashed);
    }
}