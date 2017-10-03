<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the users_questions table
		Schema::create('users_questions', function($newTable){
			$newTable -> increments('id');
			$newTable -> integer('user_id');
			$newTable -> integer('question_id');
			$newTable -> string('video');
			$newTable -> boolean('active')->default(1);
			$newTable -> timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// drop users_questions table
		Schema::dropIfExists('users_questions');
	}

}
