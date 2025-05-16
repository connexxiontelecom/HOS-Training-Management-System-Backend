<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Illuminate\Support\Facades\DB;
class States extends Model
{
    //
    public function getStates(){
        return States::all();
    }


}
