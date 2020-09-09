<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErsVisits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amd_ers_visits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id')->default(0);
            $table->integer('ers_location_id')->unsigned();
            $table->foreign('ers_location_id')->references('id')->on('amd_ers_locations');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('amd_users');
            $table->datetime('entry_time');
            $table->datetime('exit_time');
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
        Schema::dropIfExists('amd_ers_visits');
    }
}
