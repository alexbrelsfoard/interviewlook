<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the jobs table
		Schema::create('jobs', function($newTable){
			$newTable -> increments('id');
			$newTable -> integer('company_id')->unsigned();
			$newTable -> string('title');
			$newTable -> text('description');
			$newTable -> tinyInteger('type')->unsigned();
			$newTable -> string('location');
			$newTable -> boolean('remote');
			$newTable -> integer('salary_yearly')->unsigned();
			$newTable -> integer('salary_hourly')->unsigned();
			$newTable -> date('expires');
			$newTable -> timestamps();
			$newTable -> index('company_id');
			$newTable -> index('type');
			$newTable -> index('location');
			$newTable -> index('remote');
			$newTable -> index('expires');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//drop table jobs
		Schema::dropIfExists('jobs');
	}

}
