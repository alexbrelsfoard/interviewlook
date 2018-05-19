<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Notifications\ContactEmail;
use App\User;
use App\Models\Look;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Notification;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AddPipeController;

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

        //$t = new AddPipeController;
        //$t->importVideoData();

        $id = Auth::user()->id;
        $user = User::find($id);

        $video_id = round(microtime(true) * 1000);

        $video_list = Look::select('title', 'img_url')->where('user_id', $id)->get();

        $knownQuestions = Question::getDistinctQuestions();
        return view('look.looks', compact('knownQuestions', 'user', 'video_id', 'video_list'));
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

    public function startRecording(Request $request)
    {

        $id = Auth::user()->id;


        $response = array(
            'status' => 'success',
            'question' => $request->question,
            'video_id' => $request->video_id,
        );

        Look::updateOrCreate(
           ['video_id' => $request->video_id],
           ['title' => $request->question, 'user_id' => $id]
        );
        return response()->json($response);
    }
}
