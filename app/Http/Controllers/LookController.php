<?php

namespace App\Http\Controllers;

class LookController extends Controller
{
    public function demos()
    {
        return view('look.demos');
    }

    public function verifyEmail($token)
    {
        return $token;
    }

    public function about()
    {
        return view('look.contact');
    }
}
