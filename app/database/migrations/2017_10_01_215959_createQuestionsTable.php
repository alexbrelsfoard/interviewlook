<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the questions table
		Schema::create('questions', function($newTable){
			$newTable -> increments('id');
			$newTable -> string('question');
			$newTable -> string('hints');
			$newTable -> integer('creator');
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
		// drop questions table
		Schema::dropIfExists('questions');
	}

}
