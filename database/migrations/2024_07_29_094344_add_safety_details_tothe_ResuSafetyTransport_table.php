<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSafetyDetailsTotheResuSafetyTransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('ResuSafetyTransport', function (Blueprint $table) {
            $table->string('safety_details')->nullable()->after('safety_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('ResuSafetyTransport', function (Blueprint $table) {
            $table->dropColumn('safety_details');
        });
    }
}
