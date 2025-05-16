<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class approver extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'a_user_id',
    ];


    public function getApprovers(){
      $approvers = approver::all();
      $emp = new Employee();
      $apprvrs = [];
      foreach ($approvers as $approver){
          $apprvrs[]=$emp->getEmployee($approver->a_user_id);
      }
      return $apprvrs;
    }

    public function createApprovers(array $parameters){
        foreach (json_decode($parameters["approvers"]) as $approver){
            $appr = approver::firstOrNew(['a_user_id' => $approver ]);
            $appr->a_user_id = $approver;
            $appr->save();
        }
        return true;
    }

    public function removeApprover($id){
        $approver = approver::where("a_user_id", $id);
        $approver->delete();
        return true;
    }

}
