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

	public function showProfile()
	{
		return View::make('profile');
	}

	public function showPJobs()
	{
		return View::make('jobs');
	}

	public function showApplication()
	{
		return View::make('application');
	}

	public function showBook()
	{
		return View::make('book');
	}

	public function showLooks()
	{
		return View::make('looks');
	}

	public function showAccount()
	{
		return View::make('account');
	}

	public function showQuestions()
	{
		return View::make('questions');
	}

}
