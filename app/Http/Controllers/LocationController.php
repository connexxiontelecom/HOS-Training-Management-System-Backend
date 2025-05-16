<?php

namespace App\Http\Controllers;

use App\Helpers\ValidationHelper;
use App\Models\approver;
use App\Models\Countries;
use App\Models\File;
use App\Models\Locations;
use App\Models\States;
use App\Models\TrainingTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{

    public function __construct()
    {
        $this->countries = new Countries();
        $this->states = new States();
        $this->locations = new Locations();
    }

    public function getCountries()
    {
        $countries = $this->countries->getCountries();
        return response()->json($countries, 200);
    }

    public function getStates()
    {
        $states = $this->states->getStates();
        return response()->json($states, 200);
    }

    public function getLocations()
    {
        $locations = $this->locations->getLocations();
        return response()->json($locations, 200);
    }

}
