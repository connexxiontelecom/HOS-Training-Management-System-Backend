<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RecommendationsController;
use App\Http\Controllers\TrainingScheduleController;
use App\Http\Controllers\NominationController; // Added
use App\Http\Controllers\TrainingController; // Added
use App\Http\Controllers\PermissionController; // Added
use App\Http\Controllers\ApproversController; // Added
use App\Http\Controllers\YearsController; // Added
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Sanctum user route
Route::get('/user', function (Request $request) {
    return $request->user();
});
// ->middleware('auth:sanctum'); // Uncomment if Sanctum authentication is needed

// Grouped routes with no prefix (as per original)
Route::group(['prefix' => ''], function () {
    // Authentication and User Routes
    Route::post('user/create', [AuthController::class, 'createUser']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('users', [AuthController::class, 'allUsers']);

    // Employee Routes
    Route::post('employee/create', [EmployeesController::class, 'createEmployee']);
    Route::post('employee/update', [EmployeesController::class, 'updateEmployee']);
    Route::post('employees/upload', [EmployeesController::class, 'uploadDocument']);
    Route::get('employees', [EmployeesController::class, 'allEmployees']);

    // Department Routes
    Route::post('create-department', [DepartmentController::class, 'createDepartment']);
    Route::get('all-departments', [DepartmentController::class, 'allDepartments']);

    // Category Routes
    Route::get('all-categories', [CategoryController::class, 'allCategories']);
    Route::post('create-category', [CategoryController::class, 'createCategory']);

    // Recommendation Routes
    Route::post('recommendations/create', [RecommendationsController::class, 'createRecommendation']);
    Route::get('recommendations/get/{period}', [RecommendationsController::class, 'getRecommendations']);
    Route::post('recommendations/schedule', [RecommendationsController::class, 'addRecommendationToSchedule']);

    // Training Schedule Routes
    Route::post('training-schedule/create', [TrainingScheduleController::class, 'createSchedule']);
    Route::get('training-schedule/get/{period}', [TrainingScheduleController::class, 'getSchedules']);
    Route::get('training-schedule/submitted/get/{period}', [TrainingScheduleController::class, 'getSubmittedSchedules']);
    Route::post('training-schedule/submit', [TrainingScheduleController::class, 'submitSchedule']);
    Route::post('training-schedule/approved/create', [TrainingScheduleController::class, 'createApprovedTraining']);
    Route::post('training-schedule/approve', [TrainingScheduleController::class, 'approveSchedule']);
    Route::post('training-schedule/decline', [TrainingScheduleController::class, 'declineSchedule']);
    Route::post('training-schedule/update', [TrainingScheduleController::class, 'updateSchedule']);
    Route::get('training-schedule/approved/get/{period}', [TrainingScheduleController::class, 'getApprovedSchedules']);
    Route::get('training-schedule/completed/get/{period}', [TrainingScheduleController::class, 'getCompletedSchedules']);

    // Nomination Routes
    Route::post('nomination/create', [NominationController::class, 'createNomination']);
    Route::get('nomination/all-nominations', [NominationController::class, 'getNominations']);
    Route::get('nomination/nominations/{id}', [NominationController::class, 'getNominationsById']);
    Route::post('nomination/nominations/approve', [NominationController::class, 'approveNomination']);
    Route::post('nomination/nominations/decline', [NominationController::class, 'declineNomination']);
    Route::get('nomination/nominations/nominees/{id}', [NominationController::class, 'getNominee']);
    Route::post('nomination/participants/evaluate', [NominationController::class, 'updateNominee']);

    // Training Routes
    Route::post('trainings/upload', [TrainingController::class, 'uploadDocument']);
    Route::get('trainings/download/{id}', [TrainingController::class, 'downloadFile']);

    Route::get('trainings/types', [TrainingController::class, 'getTrainingTypes']);

    // Permission Routes
    Route::get('permissions/all', [PermissionController::class, 'getSystemPermissions']);
    Route::get('permissions/user/{id}', [PermissionController::class, 'getUserPermissions']);
    Route::post('permissions/create', [PermissionController::class, 'createPermission']);

    // Approver Routes
    Route::get('approvers/all', [ApproversController::class, 'getApprovers']);
    Route::get('approvers/delete/{id}', [ApproversController::class, 'removeApprover']);
    Route::post('approvers/create', [ApproversController::class, 'createApprover']);

    // Year Routes
    Route::get('years', [YearsController::class, 'getYears']);

    // Year Routes
    Route::get('locations/all', [LocationController::class, 'getLocations']);
    Route::get('locations/countries', [LocationController::class, 'getCountries']);
    Route::get('locations/states', [LocationController::class, 'getStates']);


});
