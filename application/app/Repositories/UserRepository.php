<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        return User::where('email', $email)
        ->where('password', $password)
        ->first();
    }

    public function update(User $user): void
    {
        $user->save();
    }
}
