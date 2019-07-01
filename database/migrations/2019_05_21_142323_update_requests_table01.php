<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRequestsTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amd_requests', function (Blueprint $table) {
            $table->datetime('service_date_time')->nullable()->change();
            $table->text('service_location')->nullable()->change();
            $table->string('principal_name', 100)->nullable()->change();
            $table->string('principal_mobile_no', 100)->nullable()->change();
            $table->string('principal_email', 100)->nullable()->change();
            $table->text('additional_information')->nullable()->change();
            $table->integer('region_id')->unsigned()->nullable()->change();
            $table->integer('user_id')->unsigned()->nullable()->change();
            $table->text('comments')->nullable()->change();
            $table->text('feedback')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amd_requests', function (Blueprint $table) {
            //
        });
    }
}
