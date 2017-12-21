<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile($username)
    {
        $user = User::where('username', $username)->first();
        if ($user) {
            return view('user.profile', compact('user'));
        } else {
            return view('errors.404');
        }
    }
}
