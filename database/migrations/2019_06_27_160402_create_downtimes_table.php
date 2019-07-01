<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDowntimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amd_downtimes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resource_type')->unsigned();
            $table->integer('resource_id')->unsigned();
            $table->datetime('start_date_time');
            $table->datetime('end_date_time');
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
        Schema::dropIfExists('amd_downtimes');
    }
}
