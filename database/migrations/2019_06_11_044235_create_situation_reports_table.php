<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSituationReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amd_situation_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('amd_requests');
            $table->integer('situation_id')->unsigned();
            $table->foreign('situation_id')->references('id')->on('amd_situations');
            $table->text('location');
            $table->text('close_landmark');
            $table->text('remarks');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('amd_users');
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
        Schema::dropIfExists('amd_situation_reports');
    }
}
