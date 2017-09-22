<?php

class MainController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('index');
	}

	public function showRegister()
	{
		return View::make('register');
	}

	public function showContact()
	{
		return View::make('contact');
	}

	public function showDemos()
	{
		return View::make('demos');
	}

	public function showLogin()
	{
		$data = array();
		if ($this->isPostRequest()) {
			$validator = $this->getLoginValidator();
		
			if ($validator->passes()) {
				$credentials = $this->getLoginCredentials();
	
						if (Auth::attempt($credentials)) {
							return Redirect::route("profile");
						}
						$data['error'] = "Username and Password do not match!";
			} else {
				$data['error'] = "Invalid Username or Password!";
			}
		}
		
		return View::make('login')->with($data);
	}

	public function doLogin()
	{
		
		# do the login, and then redirect to profile or account page.
	}

	public function doLogout()
	{
		
		# do the login, and then redirect to profile or account page.
	}
	
	protected function getLoginCredentials() {
		return [
			"email" 	=> Input::get("email"),
			"password" 	=> Input::get("password")
		];
	}
	
	protected function isPostRequest() {
		return Input::server("REQUEST_METHOD") == "POST";
	}
	
	protected function getLoginValidator() {
		return Validator::make(Input::all(), [
			"email" 	=> "required",
			"password" 	=> "required"
		]);
	}

}
