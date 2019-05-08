<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amd_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('acc_employees');
            $table->string('name', 100);
            $table->unique('name');
            $table->string('email', 100);
            $table->unique('email');
            $table->integer('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('amd_regions');
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
        Schema::dropIfExists('amd_users');
    }
}
