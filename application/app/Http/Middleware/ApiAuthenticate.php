<?php

namespace App\Http\Middleware;

use App\Enums\CookiesEnum;
use App\Services\TokenService;
use Closure;
use Illuminate\Http\Request;

class ApiAuthenticate
{
    public function __construct(private TokenService $tokenService)
    {
        
    }
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (
            $token === null 
            || $this->tokenService->validate($token) == false
        ) {
            return response()->json(['Not allowed'], 401);
        }

        return $next($request);
    }
}
