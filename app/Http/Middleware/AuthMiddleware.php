<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use App\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if(is_null($token))
        {
            return response()->json(['message' => 'No token supplied in request', 'code'=>401, 'data'=>[]], 401);
        }

        $this->jwtService = new Auth\JwtAuthServices();
        $isValid =  $this->jwtService->parseToken($token);

        if($isValid != true){
            return response()->json(['message' => 'Invalid token supplied in request','code'=>401, 'data' => $isValid ], 401);
        }
        else{
            return $next($request);
        }

    }
}
