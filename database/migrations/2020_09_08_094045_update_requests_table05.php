<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRequestsTable05 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amd_requests', function (Blueprint $table) {
            $table->text('detailer_review')->nullable()->after('user_id');
            $table->integer('detailer_user_id')->nullable()->after('detailer_review');
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
