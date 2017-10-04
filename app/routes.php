<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
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
	return View::make('register');
});

Route::get('/contact', function() {
	return View::make('contact');
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
		$remember_login = false;
		// check if user wants login to be remembered.  If so, set $remember to true
// 		$remember_login = ? Input::get('remember_me') true : false;
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

Route::any('/shinytuesday', function(){
	// check to make sure that these calls are coming from a safe IP address.
	// 178.62.150.224 and 85.9.27.220
	$webhookData = json_decode($_POST["payload"], true);
	$video_name = $webhookData['data']['videoName'];
	list($user_id, $question) = explode(':', $webhookData['data']['payload']);
	// lookup question to see if new one needs to be created.
	$question_lookup = DB::table('questions')->select('id')->where('question', $question)->get();
	// get question ID
	$question_id = $question_lookup['id'];
	if (!$question_id) {
		$ques = new Question();
		$ques->question = $question;
		$ques->creator = $user_id;
		$ques->save();
		$question_id = $ques->id;
	}
	
	$user_question = new UserQuestions();
	$user_question->user_id = $user_id;
	$user_question->question = $question_id;
	$user_question->video = $video_name;
	$user_question->save();
	
	// save new users_question
	print header();
	print 'OK';
});

Route::resource('job', 'JobController');

Route::group(array('before' => 'auth'), function() {
	
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
			# udate user's profile details
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
			# udate user details
			$user->name = Input::get('name');
			$user->email = Input::get('email');
			$password = Input::get('password');
			if (!empty($password)) {
				$user->password = hash::make($password);
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