<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class users_permissions extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'p_user_id', 'p_id',
    ];



    public function getPermissions($id){
       $permissions = users_permissions::where('p_user_id', $id)->get();

       foreach ($permissions as $permission){
           $permission->name = Permissions::where('id', $permission->p_id)->first()->name;
       }
       return $permissions;
    }

    public function createUserPermissions(array $parameters){
        $user = $parameters["user"];

        $permissions = users_permissions::where('p_user_id', $user);
        $permissions->delete();
        foreach (json_decode($parameters["ids"]) as $permission_id){
            $user_permissions=  new users_permissions();
            $user_permissions->p_user_id = $user;
            $user_permissions->p_id = $permission_id;
            $user_permissions->save();
        }
        return true;


       /* foreach (json_decode($parameters["ids"]) as $permission_id){
            $permission = users_permissions::updateOrCreate([
                'p_user_id'   => $user,
                'p_id'        => $permission_id
            ],[
                'p_user_id'   => $user,
                'p_id'        => $permission_id
            ]);
        }*/



    }

}
