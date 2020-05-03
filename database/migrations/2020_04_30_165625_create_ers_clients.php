<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErsClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amd_ers_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50)->nullable();
            $table->string('first_name', 100);
            $table->string('surname', 100);
            $table->text('home_address');
            $table->string('primary_phone', 20);
            $table->string('alternate_phone', 20)->nullable();
            $table->string('email', 100);
            $table->string('status', 100);
            $table->datetime('treated_at')->nullable();
            $table->integer('treated_by')->nullable();
            $table->string('access_code', 100);
            $table->unique('access_code');
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
        Schema::dropIfExists('amd_ers_clients');
    }
}
