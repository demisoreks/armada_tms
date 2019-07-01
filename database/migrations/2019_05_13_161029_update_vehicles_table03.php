<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVehiclesTable03 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amd_vehicles', function (Blueprint $table) {
            $table->boolean('active')->default(true)->after('next_service_date');
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
