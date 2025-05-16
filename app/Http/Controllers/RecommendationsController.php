<?php

namespace App\Http\Controllers;

use App\Helpers\ValidationHelper;
use App\Models\Employee;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecommendationsController extends Controller
{
    public function  __construct(){
        $this->employee = new Employee();
        $this->user = new User();
        $this->rec = new Recommendation();
    }

    public function  createRecommendation(Request $request){

        $rules = [
            'employees' => 'required',
            'Title' => 'required',
            'TypeofTraining' => 'required',
            'Description' => 'required',
            /*'Designation' => 'required',
            'Region' => 'required',*/
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }


        $parameters = $request->all();
       $result  = $this->rec->createRecommendation($parameters);
        if($result)
        {
            return response()->json("Recommendation created successfully", 200);
        }
        else{

            return response()->json("Something went wrong", 500);
        }
    }

    public function getRecommendations(Request $request, $period){
        //$parameters= $request->all();
        $recs = $this->rec->recommendations($period);
        foreach ($recs as $rec)
        {
            $rec->RecommendedBy;
            $rec->RecommendedEmployee;
            $rec->year;
        }
        return response()->json($recs, 200);
    }


    public function addRecommendationToSchedule(Request $request){
        $parameters= $request->all();
        $result = $this->rec->addRecommendationToSchedule($parameters);
        if($result)
        {
            return response()->json("Recommendation scheduled successfully", 200);
        }
        else{

            return response()->json("Something went wrong", 500);
        }
    }
}
