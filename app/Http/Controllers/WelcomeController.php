<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Notifications\RequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Notification;

class WelcomeController extends Controller
{
    public function index()
    {
        //$available_titles = Job::getDistinctTitles();
        //$job_types = Job::$types;
        //return view('look.index', compact('available_titles', 'job_types'))
         return view('look.index');
    }

    public function request(Request $request)
    {
        $v = Validator::make($request->all(), [
            'user_name' => 'required|max:50',
            'email' => 'required|email',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        } else {
            Notification::route('mail', 'rico.thompson@interviewlook.com')->notify(new RequestNotification($request->user_name, $request->email));
            session()->flash('alert-success', 'Request submitted!');
        }
        return redirect()->route('welcome');
    }
}
