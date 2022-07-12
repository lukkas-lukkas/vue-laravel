<?php

namespace App\Services;

use App\Models\User;
use ReallySimpleJWT\Token;

class TokenService
{
    private const EXPIRATION = 3600;

    public function create(User $user): string
    {
        return Token::create(
            $user->id,
            env('JWT_SECRET'),
            time() + self::EXPIRATION,
            env('APP_NAME')
        );
    }
}
