<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amd_vehicles', function (Blueprint $table) {
            $table->integer('vehicle_type_id')->unsigned()->after('driver');
            $table->foreign('vehicle_type_id')->references('id')->on('amd_vehicle_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amd_vehicles', function (Blueprint $table) {
            //
        });
    }
}
