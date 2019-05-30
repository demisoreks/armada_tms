<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amd_options', function (Blueprint $table) {
            $table->dropForeign('amd_options_option_id_foreign');
            $table->dropColumn('option_id');
            $table->integer('service_id')->unsigned()->after('id');
            $table->foreign('service_id')->references('id')->on('amd_services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amd_options', function (Blueprint $table) {
            //
        });
    }
}
