<?php

namespace Services\AllClass;

require_once "../ressources/config/rule.php";

use PDO;

 abstract class DataWizard {
    public $pdo;
    use GetPDO;

    //Get one element in table
     public function getOneElement(string $sqlRequest, array $bindParam=[]): mixed
    {
        $connect = $this->getPdo();
        $request = $connect->prepare($sqlRequest);
        $request->execute($bindParam);
        return $request->fetch();
    }
    
    //Get many elements in table
     public function getManyElements(string $sqlRequest,array $bindParam=[]): mixed
    {
        $connect = $this->getPdo();
        $request = $connect->prepare($sqlRequest);
        $request->execute($bindParam);
        return $request->fetchAll();
    }
    
    //Get all elements in table
     public function getAll(string $tableName): array
    {
        $connect = $this->getPdo();
        $request = $connect->prepare("SELECT * FROM $tableName");
        $request->execute();
        return $request->fetchAll();
    }
    
    //Insert element in table
     public function insert(string $sqlRequest,array $bindParam=[]): string|int
    {
        $connect = $this->getPdo();
        $request = $connect->prepare($sqlRequest);
        $request->execute($bindParam);
        return $connect->lastInsertId();
    }
    
    //Update element in table
     public function updateElement(string $sqlRequest,array $bindParam=[]): void
    {
        $connect = $this->getPdo();
        $request = $connect->prepare($sqlRequest);
        $request->execute($bindParam);
    }
    
    //Delete element in table 
     public function deleteElement(string $sqlRequest,array $bindParam=[]): bool
    {
        $connect = $this->getPdo();
        $request = $connect->prepare($sqlRequest);
        $request->execute($bindParam);
        return true;
    }
    
     public function counter(string $sqlRequest, array $bindParam=[]): string|int
    {
        $connect = $this->getPdo();
        $request = $connect->prepare($sqlRequest);
        $request->execute($bindParam);
        return $request->rowCount();
    }

}