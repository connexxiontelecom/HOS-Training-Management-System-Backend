<?php

namespace App\Http\Controllers;

use App\Helpers\ValidationHelper;
use App\Models\approver;
use App\Models\File;
use App\Models\TrainingTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{

    public function __construct()
    {
        $this->trainingType = new TrainingTypes();
    }

    public function  getTrainingTypes(){
        $trainingTypes =  $this->trainingType->getTrainingTypes();
        return response()->json($trainingTypes, 200);
    }

    public function uploadDocument(Request $request)
    {
        $rules = [
            'files' => 'required',
            //'files.*' => 'mimes:doc,pdf,docx,zip'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

       $parameters =  $request->all();
        foreach($parameters["files"] as $file)
        {
            $extension = $file->getClientOriginalExtension();
            $dir = 'assets/archive/resources/';
            $documentFilename = uniqid() . '.' . $extension;
            $file->move($this->public_path($dir), $documentFilename);
            $_file = new File();
            $_file->files_training_id = $parameters['training'];
            $_file->files_uploaded_by = 2;//$parameters['']
            $_file->filenames  = $documentFilename;
            $_file->save();
        }

        return response()->json("Files Uploaded Successfully ", 200);
    }



    public function public_path($path = null)
    {
        return rtrim(app()->basePath('public/' . $path), '/');
    }

    public function downloadFile($id)
    {
        $_file = File::find($id);
        $dir = 'assets/archive/resources/';
        $file = $this->public_path($dir).'/'.$_file->filenames;
        return response()->download($file);


      /* // return response()->file($file);
        return response(file($file), 200)
            ->header('Access-Control-Allow-Origin', 'http://localhost:8080')
            ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Authorization, X-Requested-With' );
        //return response()->download($file);*/
    }

}
