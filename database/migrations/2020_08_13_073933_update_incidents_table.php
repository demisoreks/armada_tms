<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amd_incidents', function (Blueprint $table) {
            $table->integer('commander')->after('follow_up_action');
            $table->integer('detailer')->after('commander');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amd_incidents', function (Blueprint $table) {
            //
        });
    }
}
