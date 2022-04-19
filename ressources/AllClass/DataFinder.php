<?php
// On veut plus tard une class qui sait envoyer des données pour chaque table
// en fonction du nom du model ou la méthode est utilisée.

namespace Services\AllClass;
require_once "../ressources/config/rule.php";

use PDO;

class DataFinder {
 public $pdo;

    public function __CONSTRUCT() 
    {
        $this ->pdo = $this->getPdo();
    }


    public function getPdo(): PDO
    {
        try{
            return new PDO(
                'mysql:dbname=tomgalton_test21_03;host=db.3wa.io;charset=UTF8',
                'tomgalton',
                'ec99b76eccf924f56e914edcbbcacbb9',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]);  
        } catch( PDOException $e) {
            echo 'merci de nous signaler le disfonctionnement';
            die();
        }
    }

    public function isThisPseudoAlreadyExist($pseudo)
    {
        $co = $this -> pdo; 
        $stmt = $co -> prepare("SELECT user_id FROM Users where user_name = :pseudo");
        $stmt -> execute([
            ":pseudo" => $pseudo
        ]);
        if(($stmt -> rowCount())>0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function isThisMailAlreadyExist($mail)
    {
        $co = $this -> pdo; 
        $stmt = $co -> prepare("SELECT user_id FROM Users where user_mail = :mail");
        $stmt -> execute([
            ":mail" => $mail
        ]);
        if(($stmt -> rowCount())>0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function pushNewUser($userMail, $userName, $userMdp)
    {

        $co = $this -> pdo;
        $query = $co -> prepare("INSERT INTO Users (user_name, mail_adress, user_mdp, language_id) 
        VALUES (:user_name, :mail_adress, :user_mdp, :language_id)");
        // $query-> bindParam(":user_name", $userName);
        // $user -> bindParam(":mail_adress", $usermail);
        // $user -> bindParam(":user_mdp", $userMdp);
        $query -> execute([
            ":user_name" => $userName,
            ":mail_adress" => $userMail,
            ":user_mdp" => $userMdp,
            ":language_id" => 1
            
        ]);
    }
    
    public function findAllUsers()
    {
        $stmt = $this->pdo -> prepare("SELECT * FROM Users");
        $stmt -> execute();
        foreach ($stmt as $row) {
            print_r($row);
        }
    }
}