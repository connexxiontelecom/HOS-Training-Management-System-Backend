<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingTypes extends Model
{

    public function getTrainingTypes(){
        return TrainingTypes::all();
    }

    public function createTrainingTypes(array $parameters){
        return true;
    }

    public function removeApprover($id){
        $training_type = TrainingTypes::where("id", $id);
        $training_type->delete();
        return true;
    }

}
