<?php
namespace Services\AllClass;
use PDO;
require_once "../ressources/config/rule.php";



trait GetPDO {
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
}