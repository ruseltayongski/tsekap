<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUniqueIdFromRiskProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('risk_profile', function (Blueprint $table) {
            $table->dropColumn('unique_id');
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
        Schema::table('risk_profile', function (Blueprint $table) {
            $table->dropColumn('unique_id');
        });
    }
}
