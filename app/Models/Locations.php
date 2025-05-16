<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Illuminate\Support\Facades\DB;
class Locations extends Model
{
    public function getLocations(){
        return Locations::all();
    }
}
