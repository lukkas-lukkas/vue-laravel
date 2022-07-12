<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TokenController extends Controller
{
    public function getToken(
        Request $request, 
        TokenService $tokenService,
        UserRepository $userRepository
    ) {
        $request->validate([
            'email' => ['email', 'required'],
            'password' => ['string', 'required'],
        ]);
    
        $user = $userRepository->findByEmailAndPassword(
            $request->get('email'),
            $request->get('password')
        );
    
        if ($user === null) {
            return response()->json([
                'message' => 'User or password invalid.'
            ])->setStatusCode(401);
        }
    
        $user->token = $tokenService->create($user);
        
        $userRepository->update($user);

        return response()->json([
            'token' => $user->token,
        ]);
    }
}
