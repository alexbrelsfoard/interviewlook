<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Job extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'jobs';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();
	
	public static $types = array('All','Full Time', 'Freelance', 'Part Time', 'Internship', 'Temporary');
	
	public function company() {
		return $this->hasOne('Company', 'id', 'company_id');
	}
	public function skills() {
		return $this->hasMany('JobSkills', 'job_id');
	}
	public function questions() {
		return $this->hasMany('JobQuestions', 'job_id');
	}
	
	public static function getDistinctTitles() {
		$result = [];
		$titles = DB::table('jobs')->select('title')->groupBy('title')->get();
		foreach ($titles as $title) {
			$result[] = $title->title;
		}
		
		return json_encode($result);
	}
}
