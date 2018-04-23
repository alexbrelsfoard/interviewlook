<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Notifications\ContactEmail;
use App\User;
use App\Http\Controllers\AddPipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Notification;
use Session;
use Illuminate\Support\Facades\Auth;

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

        $id = Auth::user()->id;
        $user = User::find($id);

        $method = 'GET';
        $url = 'https://api.addpipe.com/video/all';
        $data = '';
        $headers = array(
            'Cache-Control: no-cache',
            'content-type: application/json',
            'X-PIPE-AUTH: 8b1f187e986df04613fe4eef718a703887ca932c6d21301abaa954723daa40c2'
        );

        $get_videos = new AddPipeController();
        $video_list = $get_videos->apiRequest($method, $url, $data, $headers);

        $video_list = json_decode($video_list, true);

        $knownQuestions = Question::getDistinctQuestions();
        return view('look.looks', compact('knownQuestions', 'user', 'video_list'));
    }

    public function send(Request $request)
    {

        $v = Validator::make($request->all(), [
            'user_name' => 'required|max:191',
            'email' => 'required|email',
            'message' => "required",
        ], [
            'message.regex' => 'This is not a valid message format, please use only alpha numeric characters.',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        } else {
            Notification::route('mail', 'rico.thompson@interviewlook.com')->notify(new ContactEmail($request->all()));
            Session::flash('alert-success', 'Thank you for your feedback.');
            return redirect()->route('look.about');
        }
    }
}
