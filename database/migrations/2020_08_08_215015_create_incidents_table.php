<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amd_incidents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id');
            $table->integer('incident_type_id')->unsigned();
            $table->foreign('incident_type_id')->references('id')->on('amd_incident_types');
            $table->datetime('incident_date_time');
            $table->text('description');
            $table->text('action_taken');
            $table->text('follow_up_action');
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
        Schema::dropIfExists('amd_incidents');
    }
}
