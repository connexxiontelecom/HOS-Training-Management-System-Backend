<?php

namespace App\Http\Controllers;
use App\Helpers\ValidationHelper;
use App\Models\TrainingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->category = new TrainingCategory();
    }


    public function createCategory(Request $request)
    {

        $rules = [
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $parameters = $request->all();
        $response = $this->category->createCategory($parameters);
        if ($response != false) {
            return response()->json($response, 200);
        } else {
            return response()->json("Training Category With Name Exists Already", 409);
        }
    }

    public function allCategories()
    {
        $response = $this->category->allCategories();
        return response()->json($response, 200);
    }


}
