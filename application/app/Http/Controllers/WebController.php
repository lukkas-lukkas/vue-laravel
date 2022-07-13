<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class WebController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function login()
    {
        return view('login');
    }

    public function clients()
    {
        return view('clients');
    }
}
