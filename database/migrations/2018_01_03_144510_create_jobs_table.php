<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('type')->unsigned();
            $table->string('location')->nullable();
            $table->boolean('remote')->default(0);
            $table->integer('salary_yearly')->default(0)->unsigned();
            $table->integer('salary_hourly')->default(0)->unsigned();
            $table->date('expires');
            $table->timestamps();

            $table->index('type');
            $table->index('location');
            $table->index('remote');
            $table->index('expires');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
