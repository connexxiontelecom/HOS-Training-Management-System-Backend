<?php

namespace App\Http\Controllers;

use App\Helpers\ValidationHelper;
use App\Models\Department;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->department = new Department();
    }

    public function createDepartment(Request $request){

        $rules = [
            'name' => 'required',
            'shortname' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $parameters =  $request->all();
        $response =  $this->department->createDepartment($parameters);
        if($response !=false ){
            return response()->json($response, 200);
        }
        else{
            return response()->json("Department With Name Exists Already", 409);
        }
    }

    public function allDepartments(){
       $response = $this->department->allDepartments();
       return response()->json($response, 200);
    }


}
