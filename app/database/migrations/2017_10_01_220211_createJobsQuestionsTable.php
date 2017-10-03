<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the jobs_questions table
		Schema::create('jobs_questions', function($newTable){
			$newTable -> integer('job_id');
			$newTable -> integer('question_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// drop users table
		Schema::dropIfExists('jobs_questions');
	}

}
