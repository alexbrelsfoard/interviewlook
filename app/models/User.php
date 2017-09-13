<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	
	public static function buildMenu() {
		$menu = array(
			'Home'		=> '/',
			'Register'	=> '/register',
			'Contact Us'=> '/contact',
			'Demos'		=> '/demos',
			'Login'		=> '/login',
			'Register'	=> '/register'
		);
		
		# if logged in as lookie
/*
		$menu = array(
			'Home'		=> '/',
			'My Profile'	=> '/profile',
			'Find Jobs'	=> '/jobs',
			'My Job Application' => '/application',
			'My LOOKbook' => '/book',
			'My LOOKs'	=> '/looks',
			'My Account'=> '/account',
			'Contact Us'=> '/contact',
			'Demos'		=> '/demos',
			'Logout'	=> '/logout',
		);
*/
		
		# if logged in as looker
/*
		$menu = array(
			'Home'		=> '/',
			'Add Questions'	=> '/questions',
			'My Job' 	=> '/jobs',
			'LOOKs Received' => '/looks',
			'My LOOKbook'=> '/book',
			'My Account' => '/account',
			'Contact Us'=> '/contact',
			'Demos'		=> '/demos',
			'Logout'	=> '/logout',
		);
*/
		return $menu;
	}

}
