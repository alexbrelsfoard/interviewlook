<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the profiles table
		Schema::create('profiles', function($newTable){
			$newTable -> increments('id');
			$newTable -> integer('user_id');
			$newTable -> string('current_position');
			$newTable -> string('current_company');
			$newTable -> string('current_location');
			$newTable -> string('preferred_location');
			$newTable -> tinyInteger('years_experience');
			$newTable -> string('highest_degree');
			$newTable -> string('city');
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
		// drop profiles table
		Schema::dropIfExists('profiles');
	}

}
