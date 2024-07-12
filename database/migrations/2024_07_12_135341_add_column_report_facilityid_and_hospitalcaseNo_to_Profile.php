<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnReportFacilityidAndHospitalcaseNoToProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('profile', function (Blueprint $table) {
            $table->integer('report_facilityId')->nullable();
            $table->string('Hospital_caseno', 100)->nullable();
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
        Schema::table('profile', function (Blueprint $table) {
            $table->dropColumn(['report_facilityId']);
            $table->dropColumn(['Hospital_caseno']);
        });
    }
}
