<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the applications table
		Schema::create('applications', function($newTable){
			$newTable -> increments('id');
			$newTable -> integer('job_id');
			$newTable -> integer('user_id');
			$newTable -> text('notes');
			$newTable -> smallInteger('status');
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
		// drop applications table
		Schema::dropIfExists('applications');
	}

}
