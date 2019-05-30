<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amd_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('amd_clients');
            $table->datetime('service_date_time')->nullable;
            $table->text('service_location')->nullable;
            $table->string('principal_name', 100)->nullable;
            $table->string('principal_mobile_no', 100)->nullable;
            $table->string('principal_email', 100)->nullable;
            $table->text('additional_information')->nullable;
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('amd_status');
            $table->integer('region_id')->unsigned()->nullable;
            $table->integer('user_id')->unsigned()->nullable;
            $table->text('comments')->nullable;
            $table->text('feedback')->nullable;
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
        Schema::dropIfExists('amd_requests');
    }
}
