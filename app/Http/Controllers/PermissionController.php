<?php

namespace App\Http\Controllers;
use App\Models\Permissions;
use App\Models\User;
use App\Models\users_permissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->permissions = new Permissions();
        $this->user_permissions = new users_permissions();
    }

    public function getSystemPermissions(){
       $permissions =  $this->permissions->getSystemPermissions();
        return response()->json($permissions, 200);
    }

    Public function getUserPermissions($id){
        $permissions  =  $this->user_permissions->getPermissions($id);
        return response()->json($permissions, 200);
    }

    public function createPermission( Request $request){
        $parameters =  $request->all();
        $result  =  $this->user_permissions->createUserPermissions($parameters);
        if($result)
        {
            return response()->json("Permission(s) added successfully", 200);
        }
        else{

            return response()->json("Something went wrong", 500);
        }

    }


}
