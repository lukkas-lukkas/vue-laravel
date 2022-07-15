<?php

namespace App\Http\Middleware;

use App\Enums\CookiesEnum;
use App\Services\TokenService;
use Closure;
use Illuminate\Http\Request;

class WebAuthenticate
{
    public function __construct(private TokenService $tokenService)
    {
        
    }
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie(CookiesEnum::CLIENTS_ADMIN_TOKEN);

        if (
            $token === null 
            || $this->tokenService->validate($token) == false
        ) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
