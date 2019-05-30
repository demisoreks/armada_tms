<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amd_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('plate_number', 100);
            $table->unique('plate_number');
            $table->string('driver', 100);
            $table->integer('vendor_id')->unsigned();
            $table->foreign('vendor_id')->references('id')->on('amd_vendors');
            $table->integer('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('amd_regions');
            $table->date('next_service_date', 100);
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
        Schema::dropIfExists('amd_vehicles');
    }
}
