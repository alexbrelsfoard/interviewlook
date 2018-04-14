<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privacy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->boolean('current_position')->default(1);
            $table->boolean('current_company')->default(1);
            $table->boolean('current_location')->default(1);
            $table->boolean('preferred_location')->default(1);
            $table->boolean('years_experience')->default(1);
            $table->boolean('highest_degree')->default(1);
            $table->boolean('industry_summary')->default(1);
            $table->boolean('skills')->default(1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('privacy');
    }
}
