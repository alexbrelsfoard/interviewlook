<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the looks table
		Schema::create('looks', function($newTable){
			$newTable -> increments('id');
			$newTable -> string('title');
			$newTable -> integer('user_id');
			$newTable -> boolean('active');
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
		// drop looks table
		Schema::dropIfExists('looks');
	}

}
