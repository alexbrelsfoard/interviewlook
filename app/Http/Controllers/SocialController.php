<?php

namespace App\Http\Controllers;

use App\Notifications\AccountCreated;
use App\Notifications\EmailConfirmation;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Notification;
use Session;

class SocialController extends Controller
{
    public function linkedin()
    {
        return \Socialite::with('linkedin')->redirect();
    }

    public function linkedinCallback(Request $request)
    {
        if ($request->has('error')) {
            Session::flash('alert-danger', $request->error_description);
            return redirect(route('login'));
        }
        try {
            $response = \Socialite::driver('linkedin')->user();
            $user = $response->user;
            $data = [
                'id' => $user['id'],
                'name' => $user['formattedName'],
                'email' => $user['emailAddress'],
                'photo' => $response->avatar_original,
            ];
        } catch (Exception $e) {
            Session::flash('alert-danger', 'Something went wrong. Please try again later.');
            return redirect(route('login'));
        }

        $authUser = $this->findOrCreateUser($data, 'linkedin_id');

        Auth::login($authUser, true);
        return redirect(route('user.profile', $authUser->username));
    }

    public function facebook()
    {
        return \Socialite::with('facebook')->redirect();
    }

    public function facebookCallback(Request $request)
    {
        if ($request->has('error')) {
            Session::flash('alert-danger', $request->error_description);
            return redirect(route('login'));
        }
        try {
            $response = \Socialite::driver('facebook')->user();
            $user = $response->user;
            $data = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'photo' => $response->avatar_original,
            ];
        } catch (Exception $e) {
            Session::flash('alert-danger', 'Something went wrong. Please try again later.');
            return redirect(route('login'));
        }

        $authUser = $this->findOrCreateUser($data, 'facebook_id');

        Auth::login($authUser, true);
        return redirect(route('user.profile', $authUser->username));
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $githubUser
     * @return User
     */
    private function findOrCreateUser($data, $provider)
    {
        if ($authUser = User::where($provider, $data['id'])->orWhere('email', $data['email'])->first()) {
            User::where('email', $authUser->email)->update([
                $provider => $data['id'],
                'photo' => $data['photo'],
            ]);
            return $authUser;
        }

        $user = User::create([
            'name' => $data['name'],
            'username' => time() . '-' . slugify($data['name']),
            'email' => $data['email'],
            'email_token' => generateRandomString(25),
            $provider => $data['id'],
            'password' => '',
            'photo' => $data['photo'],
        ]);
        $user->notify(new EmailConfirmation($user->email_token));
        Notification::route('mail', 'rico.thompson@interviewlook.com')->notify(new AccountCreated($user));
        return $user;
    }
}
