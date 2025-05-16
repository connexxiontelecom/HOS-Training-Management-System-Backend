<?php

namespace App\Http\Controllers;

use App\Auth;
use App\Helpers\ValidationHelper;
use App\Models\User;
use App\Models\Permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    private Auth\JwtAuthServices $jwtService;

    public function __construct()
    {
        $this->user = new User();
        $this->permissions = new Permissions();
    }

    public function createEmployee(Request $request)
    {

        $rules = [
            'fullname' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'username' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $exists = User::where("email", $request->input('username'))->first();

        if ($exists != null) {
            return response()->json('email is taken already', 200);
        } else {
            //return response()->json(['message' => 'email is not taken already'], 409);
            $user = new User;
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->phone = $request->input('phone');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->uuid = substr(sha1(time()), 28, 40);
            $user->save();
            return response()->json('Registration Successful', 200);
        }

    }


    public function createUser(Request $request)
    {

        $rules = [
            'fullname' => 'required',
            'email' => 'required',
            'staff_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }


        $exists = $this->user->isExist($request->input('email'), $request->input('staff_id'));
        if ($exists) {
            return response()->json('User with email or ID exists already', 200);
        } else {
            $parameters = $request->all();
            $this->user->createUser($parameters);
            return response()->json('User Created Successfully', 200);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $response = $this->attemptLogin($credentials["email"], $credentials["password"]);
        if ($response != false) {
            return response()->json($response, 200);
        } else {
            return response()->json('Login Failed!, Email or Password incorrect', 401);
        }
    }

    public function attemptLogin($username, $password)
    {
        $user = User::where('email', $username)->first();
        if (!is_null($user) && Hash::check($password, $user->password)) {
            $this->jwtService = new Auth\JwtAuthServices();
            $token = $this->jwtService->init($user->uuid, $username);
            $permissions = $this->permissions->getPermissions($user->id);
            return ["user" => $user, "permissions"=>$permissions, "token" => $token];
        } else {
            return false;
        }
    }

    public function allUsers(){
       $response =  $this->user->allUsers();
       return response()->json($response, 200);
    }


}
