<?php

namespace Services\AllClass;


require_once "../ressources/config/rule.php";

 abstract class DataWizard {
    public $pdo;
    // GetPDO = trait , so need "use" 
    use GetPDO;

    //Get one element in table
    // TODO : change this method !!!
     public function getOneElement(string $sqlRequest, array $bindParam=[]): mixed
    {
        $connect = $this->GetPDO();
        $request = $connect->prepare($sqlRequest);
        $request->execute($bindParam);
        return $request->fetch();
    }
    

    //Get many elements in table
     public function getManyElements($whatever, $table, $paramForSelection, $valueForSelection)
    {
        // Using GetPDO trait
        $connect = $this->GetPDO();
        // $whatever = what is search; example $whatever = "user_name, inscription_date"
        // $table = database table where you search
        // $paramForSelection = column like user_id
        // $valueForSelection = value inside the column like 42
        $sql = "SELECT $whatever FROM $table WHERE $paramForSelection = :$paramForSelection" ;
        $request = $connect->prepare($sql);
        $request->execute([
            ":$paramForSelection" => $valueForSelection
        ]);
        return $request->fetchAll();
    }

    // A working function inside Datafinder to inspire myself
    // public function findAnythingInExchangeOfID($userID, $whatever)
    // {
    //     // $whatever should be : user_name, inscription_date, language_id, mail_adress or user_mdp
    //     $co = $this->GetPDO();
    //     $sql = "SELECT $whatever FROM Users WHERE user_id = :user_id" ;
    //     $req = $co->prepare($sql);
    //     $req->execute([
    //         ":user_id" => $userID
    //     ]);
        
    //     return $req->fetch();
    // }

    
    //Get all elements in table
    // TODO : change this method !!!
     public function getAll(string $tableName): array
    {
        $connect = $this->GetPDO();
        $request = $connect->prepare("SELECT * FROM $tableName");
        $request->execute();
        return $request->fetchAll();
    }
    
    //Insert element in table
    // TODO : change this method !!!
     public function insert(string $sqlRequest,array $bindParam=[]): string|int
    {
        $connect = $this->GetPDO();
        $request = $connect->prepare($sqlRequest);
        $request->execute($bindParam);
        return $connect->lastInsertId();
    }
    
    //Update element in table
    // TODO : change this method !!!
     public function updateElement(string $sqlRequest,array $bindParam=[]): void
    {
        $connect = $this->GetPDO();
        $request = $connect->prepare($sqlRequest);
        $request->execute($bindParam);
    }
    
    //Delete element in table 
    // TODO : change this method !!!
     public function deleteElement(string $sqlRequest,array $bindParam=[]): bool
    {
        $connect = $this->GetPDO();
        $request = $connect->prepare($sqlRequest);
        $request->execute($bindParam);
        return true;
    }
    
    // TODO : change this method !!!
     public function counter(string $sqlRequest, array $bindParam=[]): string|int
    {
        $connect = $this->GetPDO();
        $request = $connect->prepare($sqlRequest);
        $request->execute($bindParam);
        return $request->rowCount();
    }

}