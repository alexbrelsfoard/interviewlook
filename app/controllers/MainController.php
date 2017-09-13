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
		$menu = User::buildMenu();
		return View::make('index')->with('menu', $menu);
	}

	public function showRegister()
	{
		$menu = User::buildMenu();
		return View::make('register')->with('menu', $menu);
	}

	public function showContact()
	{
		$menu = User::buildMenu();
		return View::make('contact')->with('menu', $menu);
	}

	public function showDemos()
	{
		$menu = User::buildMenu();
		return View::make('demos')->with('menu', $menu);
	}

	public function showLogin()
	{
		$menu = User::buildMenu();
		return View::make('login')->with('menu', $menu);
	}

}
