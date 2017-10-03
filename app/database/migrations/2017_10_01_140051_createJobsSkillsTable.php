<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsSkillsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		// Create the jobs_skills table
		Schema::create('jobs_skills', function($newTable){
			$newTable -> integer('job_id')->unsigned();
			$newTable -> string('skill');
			$newTable -> index('job_id');
			$newTable -> index('skill');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//drop table jobs_skills
		Schema::dropIfExists('jobs_skills');
	}

}
