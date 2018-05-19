<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::post('/start-video','LookController@startRecording');

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::post('/submit/request', 'WelcomeController@request')->name('welcome.request');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Look Routes
Route::get('/demos', 'LookController@demos')->name('look.demos');
Route::get('/about', 'LookController@about')->name('look.about');
Route::post('/contact/send', 'LookController@send')->name('look.contact.send');
Route::get('/verify/email/{token}', 'LookController@verifyEmail')->name('look.verify.email');

// User Routes
Route::get('user/{username}', 'UserController@profile')->name('user.profile');
Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function () {
    Route::get('edit', 'UserController@edit')->name('profile.edit');
    Route::post('update', 'UserController@update')->name('profile.update');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/looks', 'LookController@showLooks')->name('look.looks');

    Route::get('/getvideo', function () {
        $video_name = DB::table('user_questions')->select('video')->where('user_id', auth()->user()->id)->where('id', \Illuminate\Support\Facades\Input::get('i'))->orderBy('id', 'desc')->get();
        return $video_name[0]->video;
    });

    Route::get('/uservideos', function () {
        $lastUsersQuestionsID = \Illuminate\Support\Facades\Input::get('li');
        $videos = DB::table('user_questions')->join('questions', 'questions.id', '=', 'user_questions.question_id')->select('user_questions.id', 'user_questions.video', 'questions.question')->where('user_questions.user_id', auth()->user()->id)->where('user_questions.id', '>', $lastUsersQuestionsID)->where('user_questions.active', 1)->orderBy('user_questions.id', 'asc')->get();
        //Log::warning("VIDEOS:\n".var_export($videos, true));

        $lastVideoID = 0;
        if (sizeof($videos)) {
            $lastVideoID = $videos[sizeof($videos) - 1]->id;
        }
        $data = array(
            'lastVideoID' => $lastVideoID,
            'videos' => $videos,
        );

        return json_encode($data);
    })->name('user.videos');
});

// Social Login Routes
Route::prefix('social')->group(function () {
    Route::get('linkedin', 'SocialController@linkedin')->name('social.linkedin');
    Route::get('linkedin/callback', 'SocialController@linkedinCallback')->name('social.linkedin.callback');
    Route::get('facebook', 'SocialController@facebook')->name('social.facebook');
    Route::get('facebook/callback', 'SocialController@facebookCallback')->name('social.facebook.callback');
});
