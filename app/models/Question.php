<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Question extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'questions';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();
	
	
	
	public static function getDistinctQuestions() {
		$result = [];
		$questions = DB::table('questions')->select('question')->groupBy('question')->get();
		foreach ($questions as $question) {
			$result[] = $question->question;
		}
		
		return json_encode($result);
	}
}
