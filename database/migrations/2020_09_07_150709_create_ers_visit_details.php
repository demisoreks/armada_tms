<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErsVisitDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amd_ers_visit_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ers_visit_id')->unsigned();
            $table->foreign('ers_visit_id')->references('id')->on('amd_ers_visits');
            $table->text('description');
            $table->text('option');
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
        Schema::dropIfExists('amd_ers_visit_details');
    }
}
