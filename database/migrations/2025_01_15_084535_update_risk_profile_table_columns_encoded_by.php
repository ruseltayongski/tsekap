<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRiskProfileTableColumnsEncodedBy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET foreign_key_checks = 0');

        Schema::table('risk_profile', function (Blueprint $table) {
            $table->unsignedInteger('encoded_by')->nullable(false)->after('offline_entry');
            $table->foreign('encoded_by')->references('id')->on('users')->onDelete('cascade');
        });

        DB::statement('SET foreign_key_checks = 1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_profile', function (Blueprint $table) {
            $table->dropForeign(['encoded_by']);
            $table->dropColumn('encoded_by');
        });
    }
}
