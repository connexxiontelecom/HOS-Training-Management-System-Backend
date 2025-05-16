<?php

namespace App\Http\Controllers;

use App\Helpers\ValidationHelper;
use App\Models\Employee;
use App\Models\schedule_approval;
use App\Models\TrainingSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainingScheduleController extends Controller
{
    public function __construct()
    {
        $this->employee = new Employee();
        $this->user = new User();
        $this->schedule = new TrainingSchedule();
        $this->schedule_approval = new schedule_approval();
    }

    public function createSchedule(Request $request)
    {

        $rules = [
            'Title' => 'required',
            'Description' => 'required',
            'Department' => 'required',
            'TypeofTraining' => 'required',
            'Start' => 'required',
            'End' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $parameters = $request->all();
        $result = $this->schedule->createSchedule($parameters);
        if ($result) {
            return response()->json("Training schedule created successfully", 200);
        } else {
            return response()->json("Something went wrong", 500);
        }
    }


    public function createApprovedTraining(Request $request)
    {
        $rules = [
            'Title' => 'required',
            'Description' => 'required',
            'Department' => 'required',
            'TypeofTraining' => 'required',
            'Start' => 'required',
            'End' => 'required',
            'Cost' => 'required',
            'Facilitator' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $parameters = $request->all();
        $result = $this->schedule->createApprovedTraining($parameters);
        $schedules = $this->schedule->getApprovedSchedules(0);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
        }
        return response()->json($schedules, 200);
    }

    public function getSchedules(Request $request, $period)
    {
        //$parameters= $request->all();
        $schedules = $this->schedule->getSchedules($period);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
            $schedule->approvals = $this->schedule->approvals($schedule->id);
        }
        return response()->json($schedules, 200);
    }

    public function submitSchedule (Request $request){

        $rules = [
            'schedules' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $parameters= $request->all();
        $schedules = $this->schedule->submitSchedule($parameters);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
        }
        return response()->json($schedules, 200);
    }

    public function approveSchedule (Request $request){

        $rules = [
            'schedules' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $parameters= $request->all();
        $schedules = $this->schedule->approveSchedule($parameters);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
            $schedule->approvedBy;
            $schedule->approvals = $this->schedule->approvals($schedule->id);
        }
        return response()->json($schedules, 200);
    }

    public function declineSchedule (Request $request){
        $rules = [
            'schedules' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $parameters= $request->all();
        $schedules = $this->schedule->declineSchedule($parameters);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
            $schedule->approvedBy;
            $schedule->approvals = $this->schedule->approvals($schedule->id);
        }
        return response()->json($schedules, 200);
    }

    public function updateSchedule(Request $request)
    {

        $rules = [
            'id'=>'required',
            'Title' => 'required',
            'Description' => 'required',
            'Department' => 'required',
            'TypeofTraining' => 'required',
            'Start' => 'required',
            'End' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $parameters = $request->all();
        $result = $this->schedule->updateSchedule($parameters);
        if ($result) {
            return response()->json("Training schedule updated successfully", 200);
        } else {
            return response()->json("Something went wrong",  500);
        }
    }

    public function getApprovedSchedules(Request $request, $period)
    {
        //$parameters= $request->all();
        $schedules = $this->schedule->getApprovedSchedules($period);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
            $schedule->approvals = $this->schedule->approvals($schedule->id);
        }
        return response()->json($schedules, 200);
    }



    public function getSubmittedSchedules(Request $request, $period){
        $schedules = $this->schedule->getSubmittedSchedules($period);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
            $schedule->approvals = $this->schedule->approvals($schedule->id);
        }
        return response()->json($schedules, 200);
    }


    public function getCompletedSchedules($period=0){
        $schedules = $this->schedule->getCompletedSchedules($period);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
            $schedule->files;
            $schedule->nominees;
            $schedule->approvals = $this->schedule->approvals($schedule->id);
            $schedule->ts_nominees =  count($schedule->nominees);
            foreach ($schedule->files as $file)
            {
                $file->filepath = url("/assets/archive/resources/" . $file->filenames);
            }
        }
        return response()->json($schedules, 200);
    }








}
