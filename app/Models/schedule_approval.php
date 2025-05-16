<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class schedule_approval extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'schedule_id',
        'approver_id'
    ];
    public function approveSchedule($id, $approver){
            $approval =  schedule_approval::firstOrNew(['schedule_id' =>$id, "approver_id"=> $approver]);
            $approval->status = 4;//approved
            $approval->approver_id = $approver;// approver id
            $approval->save();
        return true;
    }

    public function declineSchedule($id, $approver){
            $approval =  schedule_approval::firstOrNew(['schedule_id' =>$id, "approver_id"=> $approver]);
            $approval->status = 3;//declined
            $approval->approver_id = $approver;// approver id
            $approval->save();
        return true;
    }

    //get all the approvals for a schedule
    public function getScheduleApprovals ($id){
        return schedule_approval::where("schedule_id", $id)->get();
    }

    //get the total number of approvers
    public function getTotalApprovers (){
       return approver::all()->count();
    }

    //get the last approval for a schedule
    public function getLastApproval($id){
        return schedule_approval::where("schedule_id", $id)->orderBy('id', 'desc')->first();
    }

}
