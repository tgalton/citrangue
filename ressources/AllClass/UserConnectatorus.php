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

    public $resultReturned = NULL;

    public CONST PATTERN_MAIL = '/^\S+@\S+\.\S+$/';
    public CONST PATTERN_PWD = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/';
    // TODO : We could say if the pattern of pwd of mail is wrong to help 
    // the user.

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
            // var_dump($dataFinder -> isThisMailAlreadyExist($userMail));

            if($dataFinder -> isThisMailAlreadyExist($userMail)){
            //     // If it already exist, run further verification -> is it the right pwd ?
                $result = $dataFinder -> findUserIDByMail($userMail);
                $id = $result -> user_id;

                $pwdBDD = $dataFinder -> findAnythingInExchangeOfID($id, "user_mdp");
                // Return an object, so extract the id (int) inside.
                $pwdBDD = $pwdBDD -> user_mdp;
                if(password_verify($userPwd, $pwdBDD)){
                   
                    // This is the right pwd
                    var_dump("C'est le bon mot de passe");
                    // Start a session with Mail, Pseudo and Language.
                    session_start();
                    $_SESSION["userMail"] = $userMail;
                    $pseudoBDD = $dataFinder -> findAnythingInExchangeOfID($id, "user_name");
                    $pseudoBDD = $pseudoBDD -> user_name;
                    $_SESSION["userPseudo"] = $pseudoBDD;
                    $languageBDD = $dataFinder -> findAnythingInExchangeOfID($id, "language_id");
                    $languageBDD = $languageBDD -> user_language;
                    $_SESSION["languageID"] = $languageBDD;

                    $this -> resultReturned = TRUE;


                } else {
                    // This is the wrong pwd, but instead of an error "wrong password", we say "wrong mail or pwd".
                    $this -> registrationsErrors["general"] = "Le mot de passe ou le mail est incorrect";
                    $this -> resultReturned = FALSE;
                }
            } else {
            // Else return error and false
            $this -> registrationsErrors["general"] = "Le mot de passe ou le mail est incorrect";
            $this -> resultReturned = FALSE;
            }
        }
    }
    // TODO : a method to send a mail when the user forgot is pwd.    
}