<?php

namespace Services\AllClass;


require_once "../ressources/config/rule.php";

 abstract class DataWizard {
    public $pdo;
    // GetPDO = trait , so need "use" 
    use GetPDO;

    
    // ______________________________________
    // ***** Get many elements in table *****
    // --------------------------------------
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


    // ______________________________________
    // ******* Insert element in table ******
    // --------------------------------------
    public function insert($whateverToInsert, $table, $valuesToBind)
    {
        // $whateverToInsert is an array of the columns where data will be push
        // example : "$whateverToInsert = (user_name, mail_adress, user_mdp, language_id)"

        // $valuesToBind is an array of data to push.

        // to have prepared request we need also something like (:user_name, :mail_adress, :user_mdp, :language_id)
        // that give something like : ("INSERT INTO Users (user_name, mail_adress, user_mdp, language_id) 
    //     VALUES (:user_name, :mail_adress, :user_mdp, :language_id)")
        $connect = $this -> GetPDO();
        $whateverToInsertBinding = $whateverToInsert ;
        foreach ($whateverToInsertBinding as &$oneThingToInsert) {
            $oneThingToInsert = ":$oneThingToInsert" ;
        }
        // Must transform those array into string to be used for prepared request
        $whateverToInsertString = implode(",", $whateverToInsert);
        $whateverToInsertBindingString = implode(",", $whateverToInsertBinding);
    

        $sqlRequest = ("INSERT INTO $table ($whateverToInsertString) VALUES ($whateverToInsertBindingString)");
        $request = $connect->prepare($sqlRequest);
        $i = 0;

        // We use a foreach to produce something similare to :
            // $user -> bindParam(":mail_adress", $usermail);
            // $user -> bindParam(":user_mdp", $userMdp);
        foreach ($whateverToInsertBinding as &$oneThingToInsert) {
            $request -> bindParam($oneThingToInsert, $valuesToBind[$i]);
            $i++;
        }
        $request -> execute();
    }


    //  ________________________________________
    // |******* Get all elements in table ******|
    //  ----------------------------------------
    public function getAll($whateverToBeSelected, $tableName)
    {
        $connect = $this->GetPDO();
        $request = $connect->prepare("SELECT $whateverToBeSelected FROM $tableName");
        $request->execute();
        return $request->fetchAll();
    }


    // ______________________________________
    // ***** Get many elements in table *****
    // --------------------------------------
    public function getElement($whatever, $table, $paramForSelection, $valueForSelection)
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
        return $request->fetch();
    }

    
    // ______________________________________
    // ***** It exist ? *****
    // --------------------------------------
    public function itExist($table, $paramForSelection, $valueForSelection)
    {
        // Using GetPDO trait
        $connect = $this->GetPDO();
        // $whatever = what is search; example $whatever = "user_name, inscription_date"
        // $table = database table where you search
        // $paramForSelection = column like user_id
        // $valueForSelection = value inside the column like 42
        $sql = "SELECT * FROM $table WHERE $paramForSelection = :$paramForSelection" ;
        $request = $connect->prepare($sql);
        $request->execute([
            ":$paramForSelection" => $valueForSelection
        ]);
        $result = $request -> rowCount();
        if($result>0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
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