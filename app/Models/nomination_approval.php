<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nomination_approval extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nomination_id',
        'approver_id'
    ];
    public function approveNomination($id, $approver){
        $approval =  nomination_approval::firstOrNew(['nomination_id' =>$id, "approver_id"=> $approver]);
        $approval->status = 2;//approved
        $approval->approver_id = $approver;// approver id
        $approval->save();
        //return true;
    }

    public function declineNomination($id, $approver){
        $approval =  nomination_approval::firstOrNew(['nomination_id' =>$id, "approver_id"=> $approver]);
        $approval->status = 3;//declined
        $approval->approver_id = $approver;// approver id
        $approval->save();
        //return true;
    }

    //get all the approvals for a schedule
    public function getNominationApprovals ($id){
        return nomination_approval::where("nomination_id", $id)->get();
    }

    //get the total number of approvers
    public function getTotalApprovers (){
        return approver::all()->count();
    }

    //get the last approval for a schedule
    public function getLastApproval($id){
        return nomination_approval::where("nomination_id", $id)->orderBy('id', 'desc')->first();
    }
}
