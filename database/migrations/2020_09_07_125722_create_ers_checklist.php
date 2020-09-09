<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErsChecklist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amd_ers_checklist', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->text('options');
            $table->boolean('response')->default(true);
            $table->boolean('patrol')->default(true);
            $table->text('clients');
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
        Schema::dropIfExists('amd_ers_checklist');
    }
}
