<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('role')->default(2);
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('email_token')->nullable();
            $table->boolean('email_verified')->default(0);
            $table->boolean('account_status')->default(1);
            $table->string('facebook_id')->nullable();
            $table->string('linkedin_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
