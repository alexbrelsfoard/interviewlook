<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the users table
		Schema::create('users', function($newTable){
			$newTable -> increments('id');
			$newTable -> string('email');
			$newTable -> string('password');
			$newTable -> boolean('verified');
			$newTable -> string('name');
			$newTable -> string('company_name');
			$newTable -> tinyInteger('type'); // 1 => employee; 2 => employer
			$newTable -> tinyInteger('membership');
			$newTable -> date('start_date');
			$newTable -> date('last_billed');
			$newTable -> date('last_paid');
			$newTable -> timestamps();
		});
		
		// create a test account
	    DB::table('users')->insert(
	        array(
	            'email' 	=> 'swafo@loqqi.com',
	            'password'	=> Hash::make('1234'),
	            'verified' 	=> true,
	            'name'		=> 'Swafo Loqqi',
	            'type'		=> 1,
	            'membership'=> 0,
	            'start_date'=> DB::raw('CURRENT_TIMESTAMP')
	        )
	    );
	    DB::table('users')->insert(
	        array(
	            'email' 	=> 'alex@brelsfoard.com',
	            'password'	=> Hash::make('1234'),
	            'verified' 	=> true,
	            'name'		=> 'Alex Brelsfoard',
	            'type'		=> 2,
	            'membership'=> 1,
	            'start_date'=> DB::raw('CURRENT_TIMESTAMP')
	        )
	    );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// drop users table
		Schema::dropIfExists('users');
	}

}
