<?php

namespace App\Http\Middleware;

use App\Enums\CookiesEnum;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    protected $except = [
        CookiesEnum::VUE_LARAVEL_TOKEN
    ];
}
