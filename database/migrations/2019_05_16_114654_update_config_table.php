<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amd_config', function (Blueprint $table) {
            $table->decimal('commander_daily_cost', 20, 2)->after('link_id')->nullable;
            $table->decimal('police_daily_cost', 20, 2)->after('commander_daily_cost')->nullable;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amd_config', function (Blueprint $table) {
            //
        });
    }
}
