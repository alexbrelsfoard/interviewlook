<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/

/*
Route::get('/', 		'MainController@showWelcome');
Route::get('/register', 'MainController@showRegister');
Route::get('/contact',	'MainController@showContact');
Route::get('/demos',	'MainController@showDemos');
Route::get('/login',	'MainController@showLogin');
Route::get('/logout',	'MainController@doLogout');
*/

// Lookie / Looker
/*
Route::get('/profile',	'LookController@showProfile');
Route::get('/jobs',		'LookController@showJobs');
Route::get('/application', 'LookController@showApplication');
Route::get('/book',		'LookController@showBook');
Route::get('/looks',	'LookController@showLooks');
Route::get('/account',	'LookController@showAccount');
Route::get('/questions','LookController@showQuestions');
*/

Route::any('/', array('as'=>'home', function(){
	$data = array('results' => null);
	return View::make('index')->with($data);
}));

Route::get('/contact', function() {
	return View::make('contact');
});

Route::get('/under_development', function() {
	return View::make('under_development');
});

Route::get('/demos', function() {
	return View::make('demos');
});

Route::get('/login',	function() {
	$data = array('error'=>'');
	return View::make('login')->with($data);
});

Route::post('/login',	array('as' => 'login', function() {
	$validator = getLoginValidator();
	$data = array('error'=>'');
	if ($validator->passes()) {
		$credentials = getLoginCredentials();
		$remember_login = Input::get('remember_me');
		if (Auth::attempt($credentials, $remember_login)) {
			return Redirect::route("profile");
		}
		$data['error'] = "Username and Password do not match!";
	} else {
		$data['error'] = "Invalid Username or Password!";
		$data['errors'] = $validator->all();
	}
	return View::make('login')->with($data);
}));

Route::get('/logout',	function() {
	Auth::logout();
	return Redirect::route("home");
});

Route::get('/search', function(){
	$data = array('results' => null);
	if (Input::get('search')) {
		$jobs = Job::query();
		$title = Input::get('job_title_search');
		$location = Input::get('job_title_search');
		$type = Input::get('job_title_search');
		if ($title) {
			$jobs->where('title', 'like', '%'.$title.'%');
		}
		if ($location) {
			$jobs->where('location', $location);
		}
		if ($type) {
			$jobs->where('type', $type);
		}
		$data['results'] = $jobs->get();
	}
	return View::make('search')->with($data);
});

Route::get('/register', function() {
	$data = array('error'=>'');
	return View::make('register')->with( $data );
});

Route::post('/register', function() {
// 	read in details.
// 	create new user.
// 	send to register-thankyou
	$data = array('error'=>'');
	$validator = getAccountValidator();
	
	if ($validator->passes()) {
		# new user details
		$user = new User();
		$user->name = Input::get('name');
		$user->email = Input::get('email');
		$password = Input::get('password');
		if (!empty($password)) {
			$user->password = Hash::make($password);
		}
		$user->type = Input::get('type');
		if ($user->type == User::LOOKER) {
			$user->company_name = Input::get('company_name');
			$user->membership = Input::get('membership');
			$user->last_billed = Carbon\Carbon::now()->toDateTimeString();
		}
		$user->save();
		$data['user'] = $user;
		
		Mail::send('emails.new-user', $data, function($message) use ($user)
		{
		    $message->to($user->email, $user->name)->subject('Welcome to interviewLook!')->from('info@interviewlook.com', 'interviewLook');
		});
		
		return View::make('register-thankyou')->with( $data );
	}else {
		$data['error'] = "Missing or Invalid Field Data!";
		$data['errors'] = $validator;
		return View::make('register')->with( $data );
	}
});


//----------------------------------------------//
// --- PRIVATE ROUTES  --  MUST BE LOGGED IN  --//
//----------------------------------------------//

Route::group(array('before' => 'auth'), function() {
	
	Route::resource('job', 'JobController');

	Route::get('/profile', array('as' => 'profile', function() {
		$data = array('error'=>'');
		$data['user'] = User::find(Auth::user()->id);
		return View::make('profile')->with($data);
	}));
	
	Route::get('/edit-profile', array('as' => 'profile', function() {
		$data = array('error'=>'');
		$data['user'] = User::find(Auth::user()->id);
		return View::make('edit-profile')->with($data);
	}));
	
	Route::post('/edit-profile', function() {
		$data = array('error'=>'');
		$user = User::find(Auth::user()->id);
		$validator = getProfileValidator();
		
		if ($validator->passes()) {
			# update user's profile details
			$user->profile->current_position 	= Input::get('current_position');
			$user->profile->current_company 	= Input::get('current_company');
			$user->profile->current_location 	= Input::get('current_location');
			$user->profile->preferred_location 	= Input::get('preferred_location');
			$user->profile->years_experience 	= Input::get('years_experience');
			$user->profile->highest_degree 		= Input::get('highest_degree');
			$user->profile->city 				= Input::get('city');

			$user->save();
			
		}else {
			$data['error'] = "Missing or Invalid Field Data!";
			$data['errors'] = $validator;
		}
		$data['user'] = $user;
		return View::make('profile')->with( $data );
	});

	Route::get('/jobs', function() {
		return View::make('jobs');
	});
	
	Route::get('/application', function() {
		
		return View::make('application');
	});
	
	Route::get('/book', function() {
		return View::make('book');
	});
	
	Route::get('/looks', function() {
		$data = array('error'=>'');
		$data['user'] = User::find(Auth::user()->id);
		return View::make('looks')->with( $data );
	});
	
//	Route::post('/savelook' function() {
//		$data = array('error'=>'');
		//$data['user'] = User::find(Auth::user()->id);
		//$look_title   = Input::get('t');
		//$look_videos  = json_decode(Input::get('l'));
		# save the look in the system.
		
		# return the new id.
//		return "OK";
//	});
	
	Route::get('/account', function() {
		$data = array('error'=>'');
		$data['user'] = User::find(Auth::user()->id);
		return View::make('account')->with($data);
	});
	
	Route::post('/account', function() {
		$data = array('error'=>'');
		$user = User::find(Auth::user()->id);
		$validator = getAccountValidator();
		
		if ($validator->passes()) {
			# update user details
			$user->name = Input::get('name');
			$user->email = Input::get('email');
			$password = Input::get('password');
			if (!empty($password)) {
				$user->password = Hash::make($password);
			}
			$user->save();
			
		}else {
			$data['error'] = "Missing or Invalid Field Data!";
			$data['errors'] = $validator;
		}
		$data['user'] = $user;
		return View::make('account')->with( $data );
	});
	
	Route::get('/questions', function() {
		return View::make('questions');
	});
	
	Route::get('/getvideo', function(){
		$video_name = DB::table('users_questions')->select('video')->where('user_id',Auth::user()->id)->where('id', Input::get('i'))->orderBy('id', 'desc')->get();
		return $video_name[0]->video;
	});
	
	Route::get('/uservideos', function(){
		$lastUsersQuestionsID = Input::get('li');
		$videos = DB::table('users_questions')->join('questions', 'questions.id','=','users_questions.question_id')->select('users_questions.id', 'users_questions.video', 'questions.question')->where('users_questions.user_id', Auth::user()->id)->where('users_questions.id','>',$lastUsersQuestionsID)->where('users_questions.active', 1)->orderBy('users_questions.id', 'asc')->get();
		//Log::warning("VIDEOS:\n".var_export($videos, true));
		
		$lastVideoID = 0;
		if (sizeof($videos)) {
			$lastVideoID = $videos[sizeof($videos)-1]->id;
		}
		$data = array(
			'lastVideoID' => $lastVideoID,
			'videos' => $videos
		);
		
		return json_encode($data);
	});
});


// SECRET API CALL TO RECEIVE DATA FROM addpipe.com ABOUT VIDEOS BEING MADE
// http://interviewlook.localhost.com/shinytuesday/?payload={"version":"1.0","event":"video_copied_ftp","data":{"ftpUploadStatus":"upload success","videoName":"vsrtc1507127055_449","duration":5.83,"audioCodec":"AAC","videoCodec":"H.264","type":"MP4","size":261862,"width":640,"height":480,"orientation":"landscape","id":"559198","payload":"1:Testing","httpReferer":"https://www.interviewlook.com/looks"}}
Route::post('/shinytuesday', function(){
	// check to make sure that these calls are coming from a safe IP address.
	// 178.62.150.224 and 85.9.27.220
	// also check payload->data->httpReferer should be https://www.interviewlook.com/looks
	$webhookData = json_decode(Input::get("payload"), true);
	$video_name = $webhookData['data']['videoName'];
// 	Log::warning('**** Video Received: '.$video_name);
	list($user_id, $question) = explode(':', $webhookData['data']['payload']);
	// lookup question to see if new one needs to be created.
	$question_lookup = DB::table('questions')->select('id')->where('question', $question)->get();
//  	Log::warning('**** Questions lookup: '.var_export($question_lookup, true));

	// get question ID
	if (empty($question_lookup) || gettype($question_lookup) != 'array') {
		// new question; save it.
		$ques = new Question();
		$ques->question = $question;
		$ques->creator = $user_id;
		$ques->save();
		$question_id = $ques->id;
	}else {
		$question_id = $question_lookup[0]->id;
	}
	
	// save new users_question
	$user_question = new UserQuestions();
	$user_question->user_id = $user_id;
	$user_question->question_id = $question_id;
	$user_question->video = $video_name;
	$user_question->save();
	
	print 'OK';
});
	
function getLoginCredentials() {
	return [
		"email" 	=> Input::get("email"),
		"password" 	=> Input::get("password")
	];
}

function isPostRequest() {
	return Input::server("REQUEST_METHOD") == "POST";
}

function getLoginValidator() {
	return Validator::make(Input::all(), [
		"email" 	=> "required",
		"password" 	=> "required"
	]);
}

function getAccountValidator() {
	return Validator::make(Input::all(), [
		"email" 	=> "required",
		"name" 		=> "required",
		"password"	=> "min:6",
		"password_comfirm"	=> "same:password"
	]);
}

function getProfileValidator() {
	return Validator::make(Input::all(), [
	]);
}