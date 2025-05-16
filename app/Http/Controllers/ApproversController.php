<?php

namespace App\Http\Controllers;

use App\Models\approver;
use App\Models\Permissions;
use App\Models\users_permissions;
use Illuminate\Http\Request;

class ApproversController extends Controller
{
    public function __construct()
    {
        $this->approver = new approver();
    }

    public function getApprovers(){
        $approvers =  $this->approver->getApprovers();
        return response()->json($approvers, 200);
    }

    Public function createApprover(Request $request){
        $parameters =  $request->all();
        $result  =  $this->approver->createApprovers($parameters);
        if($result)
        {
            return response()->json("Approver(s) added successfully", 200);
        }
        else{
            return response()->json("Something went wrong", 500);
        }
    }



    public function removeApprover($id){

        $result= $this->approver->removeApprover($id);

        if($result)
        {
            return response()->json("Approver(s) removed successfully", 200);
        }
        else{
            return response()->json("Something went wrong", 500);
        }
    }


}
