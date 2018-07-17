<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Notifications\ContactEmail;
use App\User;
use App\Models\Look;
use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Notification;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AddPipeController;

class LookController extends Controller
{
    public function index() {
        $id = Auth::user()->id;
        $interviews = interview::where('user_id', $id)->paginate(5);
        return view('look.looks.index')->withInterviews($interviews);
    }

    public function create() {
        return view('look.looks.create');
    }

    public function show($id) {

        $user_id = Auth::user()->id;

        //$video_list = Look::select('title', 'img_url')->where('user_id', $id)->get();

        $videos = Look::orderBy('order')
                  ->where('interview_id', $id)
                  ->where('user_id', $user_id)
                  ->get();

        $videosSaved = $videos->filter(function ($task, $key) {
            return  ! $task->status;
        })->values();


        return view('look.looks.show', compact('videosSaved', 'id'));

    }

    public function edit($id) {

        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $interview = interview::find($id);

        $video_id = round(microtime(true) * 1000);

        $videos = Look::orderBy('order')
                  ->where('interview_id', $id)
                  ->where('user_id', $user_id)
                  ->get();

        $videosCompiled = $videos->filter(function ($task, $key) {
            return $task->status;
        })->values();

        $videosSaved = $videos->filter(function ($task, $key) {
            return  ! $task->status;
        })->values();


        $knownQuestions = Question::getDistinctQuestions();

        return view('look.looks.edit', compact('knownQuestions', 'user', 'video_id', 'videos', 'videosCompiled', 'videosSaved', 'interview'));

    }

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

        //$video_list = Look::select('title', 'img_url')->where('user_id', $id)->get();

        $videosCompiled = Look::orderBy('order')->where('user_id', $id)->where('status', 1)->get();

        $videosSaved = interview::where('user_id', $id)->with(array('looks'=>function($query){
            $query->where('status', 0);
        }))->get();

        // $videosSaved = $videos->filter(function ($task, $key) {
        //     return  ! $task->status;
        // })->groupBy('interview_id');

        // dd($videosSaved);

        $knownQuestions = Question::getDistinctQuestions();

        return view('look.looks', compact('knownQuestions', 'user', 'video_id', 'videos', 'videosCompiled', 'videosSaved'));
    }

    public function videosData() {
        $videosCompiled = Look::orderBy('order')->where('user_id', Auth::user()->id)->where('status', 1)->get();

        $videosSaved = interview::where('user_id', Auth::user()->id)->with(array('looks'=>function($query){
            $query->where('status', 0);
        }))->get();

        return response()->json([
            'videosCompiled' => $videosCompiled,
            'videosSaved' => $videosSaved,
        ]);
    }
    public function editTitle(Request $request) {
        $interview = Interview::find($request->id);
        $interview->title = $request->title;
        $interview->save();
        return "success";
    }

    public function addInterview(Request $request) {
        $interview = new Interview;
        $interview->user_id = Auth::user()->id;
        $interview->title = $request->title;
        $interview->save();
        return redirect()->route('look.edit', $interview->id);
    }

    public function updateTasksStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|boolean',
        ]);

        $video = Look::find($id);
        $video->status = $request->status;
        $video->save();

        return response('Updated Successfully.', 200);

    }

    public function updateTasksOrder(Request $request)
    {
        $this->validate($request, [
            'tasks.*.order' => 'required|numeric',
        ]);

        $videos = Look::all();

        foreach ($videos as $video) {
            $id = $video->id;
            foreach ($request->tasks as $videosNew) {
                if ($videosNew['id'] == $id) {
                    $video->update(['order' => $videosNew['order']]);
                }
            }
        }

        return response('Updated Successfully.', 200);
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

        $image = $request->image_blob;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = str_random(10).'.'.'png';

        \File::put(public_path(). '/uploads/thumbnails/' . $imageName, base64_decode($image));

        $response = array(
            'status' => 'success',
            'question' => $request->question,
            'video_id' => $request->video_id,
        );

        Look::updateOrCreate(
           ['video_id' => $request->video_id],
           ['title' => $request->question,
            'user_id' => $id,
            'img_url' =>  $imageName,
            'interview_id' => $request->interview_id
            ]
        );

        return response()->json($response);
    }

    public function uploadVideo(Request $request) 
    {

            
            $file_idx = 'video-blob';
            $fileName = $request['video-filename'];
            $tempName = $request->file('video-blob')->getPathName();
            if (empty($fileName) || empty($tempName)) {
                if(empty($tempName)) {
                    echo 'Invalid temp_name: '.$tempName;
                    return;
                }

                echo 'Invalid file name: '.$fileName;
                return;
            }
            
            $filePath = 'uploads/videos/' . $fileName;
            
            // make sure that one can upload only allowed audio/video files
            $allowed = array(
                'webm'
            );
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            if (!$extension || empty($extension) || !in_array($extension, $allowed)) {
                echo 'Invalid file extension: '.$extension;
                return;
            }
            
            if (!move_uploaded_file($tempName, $filePath)) {
                echo 'Problem saving file: '.$tempName;
                return;
            }
            
            echo 'success';


    }

    public function delete(Request $request){
        $look = Look::find($request->id);
        \File::delete(public_path(). '/uploads/videos/'.$look->video_id.'.webm');
        \File::delete(public_path(). '/uploads/thumbnails/'.$look->img_url);
        $look->delete();
    }

    public function interviewDelete(Request $request){
        $interview = Interview::find($request->id);
        $looks = Look::where('interview_id', $request->id)->get();
        foreach ($looks as $look) {
            \File::delete(public_path(). '/uploads/videos/'.$look->video_id.'.webm');
            \File::delete(public_path(). '/uploads/thumbnails/'.$look->img_url);
            $look->delete();
        }
        $interview->delete();
    }
}
