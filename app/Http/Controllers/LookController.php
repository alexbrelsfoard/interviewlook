<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Notifications\ContactEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Notification;
use Session;

class LookController extends Controller
{
    public function demos()
    {
        return view('look.demos');
    }

    public function verifyEmail($token)
    {
        $user = User::where('email_token', $token)->first();
        if ($user) {
            User::where('id', $user->id)->update(['email_verified' => 1]);
            Session::flash('alert-success', 'Email verified successfully.');
            return redirect()->route('user.profile', $user->username);
        } else {
            Session::flash('alert-danger', 'Email verificaion link expired. Please try again later.');
            return redirect()->route('welcome');
        }
    }

    public function about()
    {
        return view('look.contact');
    }

    public function showLooks()
    {
        $knownQuestions = Question::getDistinctQuestions();
        return view('look.looks', compact('knownQuestions'));
    }

    public function send(Request $request)
    {

        $v = Validator::make($request->all(), [
            'user_name' => 'required|max:191',
            'email' => 'required|email',
            'message' => "required|regex:/^[\r\n0-9a-zA-Z \/_:,.?@;-]+$/",
        ], [
            'message.regex' => 'This is not a valid message format, please use only alpha numeric characters.',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        } else {
            Notification::route('mail', 'rico.thompson@interviewlook.com')->notify(new ContactEmail($request->all()));
            Session::flash('alert-success', 'Email sent successfully.');
            return redirect()->route('look.about');
        }
    }
}
