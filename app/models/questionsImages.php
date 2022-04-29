<?php
namespace App\Models;
use Services\AllClass\DataWizard ;

class QuestionsImages extends DataWizard 
{
    public $actualTable =  "PossibleAnswersMaster"; 
    public function addNewImage(
        $imagePath,
        $imageOrder,
        $isInstruction
    )
    {
        // $whateverToInsert = columns of insertion : All except ID
        // ID is not require because automatically generated.
        $whateverToInsert = ("image_path, image_order, is_instruction");
        $table = $actualTable;
        $valuesToBind = array(
            $imagePath,
            $imageOrder,
            $isInstruction
        );

        $result = $this -> insert(
            $whateverToInsert, 
            $table, 
            $valuesToBind
        );
    }
}