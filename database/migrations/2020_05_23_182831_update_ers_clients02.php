<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateErsClients02 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amd_ers_clients', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('surname');
            $table->string('gender', 10)->nullable()->after('date_of_birth');
            $table->string('occupation', 100)->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amd_ers_clients', function (Blueprint $table) {
            //
        });
    }
}
