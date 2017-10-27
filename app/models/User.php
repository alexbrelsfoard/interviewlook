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
	
	const LOOKIE = 1;
	const LOOKER = 2;
	
	
	public function profile() {
		return $this->hasOne('Profile', 'user_id');
	}
	public function questions() {
		return $this->hasMany('UserQuestions', 'user_id');
	}
	
	public static function buildMenu() {
		$menu = array(
			'Home'		=> '/',
			'Register'	=> '/register',
			'Contact Us'=> '/contact',
			'Demos'		=> '/demos',
			'Login'		=> '/under_development',//'/login',
			'Register'	=> '/under_development',//'/register'
		);
		
		if (Auth::check()) {
			# if logged in as lookie
			if (Auth::user()->type == 1) {
			$menu = array(
				'Home'		=> '/',
				'My Profile'	=> '/profile',
				'Find Jobs'	=> '/',
				'My Submitted LOOKs' => '/applications',
				'My LOOKBook' => '/book',
				'My LOOKs'	=> '/looks',
				'My Account'=> '/account',
				'Contact Us'=> '/contact',
				'Demos'		=> '/demos',
				'Logout'	=> '/logout',
			);
			}
			# if logged in as looker
			else {
			
				$menu = array(
					'Home'		=> '/',
					'Add Questions'	=> '/questions',
					'My Job' 	=> '/jobs',
					'LOOKs Received' => '/looks',
					'My Account' => '/account',
					'Contact Us'=> '/contact',
					'Demos'		=> '/demos',
					'Logout'	=> '/logout',
				);
			}
		}
		return $menu;
	}

}
