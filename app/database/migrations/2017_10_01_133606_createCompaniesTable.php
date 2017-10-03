<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the companies table
		Schema::create('companies', function($newTable){
			$newTable -> increments('id');
			$newTable -> string('name');
			// have the logo be: /images/logos/{companies_id}.{ext}
			$newTable -> string('logo')->default('/images/logos/default.jpg');
			$newTable -> string('location');
			$newTable -> text('description');
			$newTable -> string('tag_line');
			$newTable -> string('url');
			$newTable -> boolean('active');
			$newTable -> timestamps();
			$newTable -> index('active');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// drop companies table
		Schema::dropIfExists('companies');
	}

}
