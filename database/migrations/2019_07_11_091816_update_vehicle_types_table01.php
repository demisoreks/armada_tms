<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVehicleTypesTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amd_vehicle_types', function (Blueprint $table) {
            $table->decimal('pick_and_drop_cost', 20, 2)->after('features')->nullable();
            $table->decimal('average_daily_cost', 20, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amd_vehicle_types', function (Blueprint $table) {
            //
        });
    }
}
