<?php

namespace App\Http\Controllers;

use App\Helpers\ValidationHelper;
use App\Models\Employee;
use App\Models\Nomination;
use App\Models\TrainingSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NominationController extends Controller
{
    public function __construct()
    {
        $this->nomination = new Nomination();
        $this->schedule = new TrainingSchedule();
        $this->employee= new Employee();
    }

    public function createNomination(Request $request)
    {
        $rules = [
            'ids' => 'required',
            'schedule' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $parameters = $request->all();
        $result = $this->nomination->createNomination($parameters);
        if ($result) {
            return response()->json("Nominations submitted successfully", 200);
        } else {
            return response()->json("Something went wrong", 500);
        }
    }

    public function getNominations(){
       $nominations =  $this->nomination->getNominations();
       foreach ($nominations as $nomination)
       {
           $nomination->training = $this->schedule->getSchedule($nomination->nm_training_id);
           $nomination->NominatedBy;
           $nomination->NominatedEmployee;
           $nomination->year;
           $approvals = $nomination->approvals;
           foreach ($approvals as $approval) {
               $approval->employee =  $this->employee->getEmployee($approval->approver_id);
           }
       }
        if ($nominations) {
            return response()->json($nominations, 200);
        } else {
            return response()->json("Something went wrong", 500);
        }
    }

    public function getNominationsById(Request $request, $id){
        $nominations =  $this->nomination->getNominationsByMe($id);
        if ($nominations) {
            return response()->json($nominations, 200);
        } else {
            return response()->json("Something went wrong", 500);
        }
    }

    public function approveNomination(Request $request)
    {
        $result = $this->nomination->approveNomination($request->all());
        return response()->json($result, 200);
    }

    public function declineNomination(Request $request){
        $result = $this->nomination->declineNomination($request->all());
        return response()->json($result, 200);
    }

    public function getNominee(Request $request, $id){
        $nominees = $this->nomination->getNominees($id);

        foreach ($nominees as $nominee)
        {
            $nominee->NominatedEmployee;
            //$nominee->em = $this->employee->getEmployee($nominee->nm_employee_id);
            //$nominee->NominatedBy;
            //$nominee->year;
        }
        if ($nominees) {
            return response()->json($nominees, 200);
        } else {
            return response()->json("Something went wrong", 500);
        }

    }

    public function updateNominee(Request $request){

        $rules = [
            'nominees' => 'required',
            'schedule' => 'required',
            'SummaryNote'=>'required',
            'FacilitatorRating'=>'required',
            'TrainingRating'=>'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $parameters = $request->all();
        $result  =  $this->nomination->updateNominees($parameters);
        if ($result) {
            return response()->json("Evaluation Submitted Successfully", 200);
        } else {
            return response()->json("Something went wrong", 500);
        }
    }




}
