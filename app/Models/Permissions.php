<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permissions extends Model
{
    public function getPermissions($id){
        $userPermissions = new users_permissions();
        return $userPermissions->getPermissions($id);
    }

    public function getSystemPermissions(){
        //return DB::getSchemaBuilder()->getColumnListing('permissions');
        return Permissions::all();
    }
}
